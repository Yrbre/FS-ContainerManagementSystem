# Rencana Perbaikan Koneksi WhatsApp

Dokumen ini berisi rencana teknis untuk mengurangi koneksi WhatsApp yang terputus tiba-tiba dan mencegah pesan notifikasi hilang.

## 1. Masalah saat ini

Implementasi saat ini memiliki beberapa risiko:

1. Service Whatspie menggunakan host `172.16.10.114:3000` yang ditulis langsung di kode.
2. Tidak ada monitoring otomatis yang berjalan berkala.
3. Tidak ada mekanisme auto-reconnect ketika sesi terputus.
4. Request HTTP belum memiliki timeout dan retry yang konsisten.
5. Pesan gagal kirim hanya dicatat ke log dan tidak dimasukkan ke antrean pengiriman ulang.
6. Dashboard langsung menonaktifkan konfigurasi `whatsapp-notif` saat mendeteksi koneksi terputus.
7. Service Whatspie dapat berhenti tanpa mekanisme restart otomatis.

## 2. Target perbaikan

Target setelah perbaikan:

- Service Whatspie otomatis hidup kembali ketika crash.
- Status WhatsApp diperiksa secara berkala tanpa menunggu dashboard dibuka.
- Gangguan jaringan sementara ditangani dengan retry bertahap.
- Sesi yang terputus dicoba untuk dipulihkan secara otomatis.
- Pesan notifikasi tidak hilang ketika WhatsApp sedang tidak tersedia.
- Administrator mendapat peringatan jika koneksi gagal dalam periode tertentu.
- Konfigurasi dapat diubah melalui `.env` tanpa mengubah source code.

## 3. Arsitektur yang disarankan

```text
Laravel Scheduler
        |
        v
WhatsApp Health Check
        |
        +-- CONNECTED
        |       |
        |       v
        |   Simpan status sehat
        |
        +-- DISCONNECTED
        |       |
        |       v
        |   Coba reconnect dengan backoff
        |
        +-- Gagal berulang
                |
                v
        Kirim alert ke administrator

Posting inspeksi
        |
        v
Simpan pesan ke queue/outbox
        |
        v
Worker pengiriman WhatsApp
        |
        +-- Berhasil -> tandai terkirim
        |
        +-- Gagal -> retry
```

## 4. Tahap 1: pindahkan konfigurasi ke `.env`

Tambahkan URL service ke `.env`:

```env
WHATSPIE_URL=http://172.16.10.114:3000
WHATSPIE_SECRET_KEY=isi_api_key_whatspie
WHATSPIE_GROUP_ID=isi_chat_id_grup
SESSION_ID_WA=isi_session_id

WHATSPIE_CONNECT_TIMEOUT=5
WHATSPIE_TIMEOUT=30
WHATSPIE_MAX_RETRIES=3
```

Tambahkan konfigurasi tersebut ke [`config/services.php`](config/services.php):

```php
'whatspie' => [
    'url' => env('WHATSPIE_URL'),
    'secret' => env('WHATSPIE_SECRET_KEY'),
    'group' => env('WHATSPIE_GROUP_ID'),
    'session' => env('SESSION_ID_WA'),
    'connect_timeout' => (int) env('WHATSPIE_CONNECT_TIMEOUT', 5),
    'timeout' => (int) env('WHATSPIE_TIMEOUT', 30),
    'max_retries' => (int) env('WHATSPIE_MAX_RETRIES', 3),
],
```

Kemudian ubah [`WhatspieService`](app/Services/WhatspieService.php) agar seluruh endpoint menggunakan `config('services.whatspie.url')`.

## 5. Tahap 2: perbaiki HTTP client

Gunakan satu HTTP client yang memiliki:

- `connectTimeout`;
- `timeout`;
- retry untuk error koneksi dan response `5xx`;
- header autentikasi yang konsisten;
- logging endpoint, status response, dan durasi request;
- validasi response sebelum dianggap berhasil.

Contoh pola implementasi:

```php
$this->client = Http::baseUrl(config('services.whatspie.url'))
    ->withHeaders([
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
        'x-api-key' => config('services.whatspie.secret'),
    ])
    ->connectTimeout(config('services.whatspie.connect_timeout'))
    ->timeout(config('services.whatspie.timeout'))
    ->retry(
        config('services.whatspie.max_retries'),
        [1000, 3000, 10000]
    );
```

Jika tetap menggunakan Guzzle, konfigurasi timeout dan retry harus diterapkan pada setiap request.

> Jangan mencatat API key, isi pesan sensitif, atau kredensial ke log.

## 6. Tahap 3: tambahkan health check berkala

Buat command, misalnya:

```text
php artisan whatsapp:health-check
```

Command tersebut harus:

1. Memanggil endpoint status sesi.
2. Mencatat status koneksi.
3. Menyimpan waktu terakhir status `CONNECTED`.
4. Mendeteksi perubahan dari `CONNECTED` menjadi `DISCONNECTED`.
5. Mencoba pemulihan sesi jika service mendukungnya.
6. Mengirim alert hanya setelah kegagalan berlangsung beberapa kali.

Daftarkan scheduler setiap satu menit:

```php
$schedule->command('whatsapp:health-check')
    ->everyMinute()
    ->withoutOverlapping();
```

Scheduler harus selalu berjalan di server. Contoh cron Linux:

```text
* * * * * cd /path/aplikasi && php artisan schedule:run >> /dev/null 2>&1
```

Untuk Windows, jalankan `php artisan schedule:work` sebagai Windows Service atau gunakan Task Scheduler.

## 7. Tahap 4: buat auto-reconnect yang aman

Auto-reconnect tidak boleh melakukan request tanpa batas. Gunakan batas percobaan dan jeda bertahap:

```text
Percobaan 1: 10 detik
Percobaan 2: 30 detik
Percobaan 3: 60 detik
Percobaan berikutnya: 5 menit
```

Aturan yang disarankan:

- Jangan memanggil `startSession()` jika status masih `CONNECTED`.
- Jangan menjalankan dua proses reconnect untuk session yang sama.
- Gunakan lock/cache agar proses tidak berjalan bersamaan.
- Reset jumlah percobaan setelah status kembali `CONNECTED`.
- Jika QR code diperlukan, tandai status sebagai `WAITING_FOR_QR` dan kirim alert kepada administrator.

Auto-reconnect hanya dapat memulihkan service atau koneksi yang memang masih memiliki session valid. Jika WhatsApp meminta pairing ulang, administrator tetap harus memindai QR code.

## 8. Tahap 5: jangan langsung menonaktifkan notifikasi

Pada [`DashboardController`](app/Http/Controllers/Console/DashboardController.php), saat ini konfigurasi `whatsapp-notif` langsung dinonaktifkan ketika status tidak `CONNECTED`.

Perilaku yang lebih aman:

```text
1 kali gagal       -> catat warning
3 kali gagal       -> coba reconnect
5 menit gagal      -> kirim alert
15 menit gagal     -> tandai layanan bermasalah
```

Konfigurasi pengiriman sebaiknya tetap aktif selama proses pemulihan. Status koneksi dan status fitur notifikasi juga sebaiknya dipisahkan:

- `connection_status`: kondisi aktual Whatspie.
- `notification_enabled`: izin bisnis untuk mengirim notifikasi.

Dengan demikian, gangguan sementara tidak mengubah pengaturan bisnis secara otomatis.

## 9. Tahap 6: gunakan queue untuk pengiriman pesan

Pengiriman WhatsApp sebaiknya tidak mengikat keberhasilan transaksi inspeksi secara langsung.

Buat job, misalnya:

```text
SendWhatsappMessage
```

Alur:

1. Inspeksi berhasil diposting.
2. Aplikasi membuat job pengiriman WhatsApp.
3. Worker mengambil job.
4. Job memanggil `sendMessageToGroup()`.
5. Jika berhasil, job selesai.
6. Jika gagal, job diulang dengan backoff.
7. Setelah batas percobaan habis, job masuk `failed_jobs` dan administrator diberi alert.

Contoh kebijakan retry:

```text
tries: 5
backoff: 60, 300, 900, 1800 detik
```

Gunakan idempotency key atau ID inspeksi agar pesan tidak terkirim ganda ketika worker melakukan retry.

## 10. Tahap 7: jalankan worker secara permanen

Queue tidak akan berguna jika worker berhenti. Jalankan worker menggunakan process supervisor.

Pilihan yang dapat digunakan:

- Supervisor pada Linux;
- systemd pada Linux;
- Docker dengan `restart: always`;
- NSSM atau Windows Service pada Windows;
- Task Scheduler untuk proses yang sesuai dengan lingkungan server.

Worker harus memiliki:

- auto-restart;
- batas memory;
- logging;
- monitoring proses;
- notifikasi ketika berhenti.

## 11. Tahap 8: monitoring service Whatspie

Selain memonitor dari Laravel, service Whatspie sendiri harus dipastikan selalu hidup.

Health check minimum:

```text
GET http://172.16.10.114:3000/session/status/{SESSION_ID_WA}
```

Monitor perlu membedakan:

- server Whatspie tidak dapat diakses;
- API dapat diakses tetapi session disconnected;
- session membutuhkan QR code;
- API mengembalikan error autentikasi;
- WhatsApp berhasil terkoneksi.

Setiap kondisi harus memiliki pesan dan tindakan pemulihan yang berbeda.

## 12. Checklist implementasi

### Prioritas tinggi

- [ ] Pindahkan URL Whatspie ke `.env`.
- [ ] Tambahkan timeout dan retry.
- [ ] Pastikan service Whatspie menggunakan auto-restart.
- [ ] Buat command health check.
- [ ] Jalankan scheduler setiap menit.
- [ ] Tambahkan lock pada proses reconnect.

### Prioritas menengah

- [ ] Pindahkan pengiriman pesan ke queue.
- [ ] Tambahkan retry job dan `failed_jobs`.
- [ ] Tambahkan alert ketika retry habis.
- [ ] Pisahkan status koneksi dari konfigurasi enable/disable.

### Prioritas jangka panjang

- [ ] Tambahkan dashboard monitoring uptime.
- [ ] Simpan histori perubahan status koneksi.
- [ ] Tambahkan pengujian untuk timeout, retry, disconnect, dan reconnect.
- [ ] Evaluasi migrasi ke WhatsApp Business Platform/API resmi.

## 13. Batasan yang tetap harus dipahami

Auto-reconnect tidak dapat menjamin koneksi 100% selalu aktif. Jika sesi WhatsApp logout, QR code kedaluwarsa, perangkat utama bermasalah, atau WhatsApp memblokir sesi otomatis, administrator tetap harus melakukan pairing ulang.

Untuk kebutuhan produksi yang kritis, WhatsApp Business Platform/API resmi lebih stabil dibandingkan koneksi berbasis sesi QR WhatsApp Web.
