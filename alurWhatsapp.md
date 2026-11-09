# Alur WhatsApp

Dokumen ini menjelaskan alur integrasi WhatsApp pada aplikasi Baracoal CMS berdasarkan implementasi saat ini.

## 1. Komponen yang terlibat

| Komponen | Peran |
|---|---|
| [`WhatspieService`](app/Services/WhatspieService.php) | Wrapper HTTP untuk mengakses service Whatspie. |
| [`ConfigController`](app/Http/Controllers/Console/Master/ConfigController.php) | Memulai dan menghentikan sesi WhatsApp dari halaman konfigurasi. |
| [`ButtonAction`](app/Http/Livewire/WAService/ButtonAction.php) | Membaca status sesi dan menampilkan tombol `Start` atau `Terminate`. |
| [`QRCodeModal`](app/Http/Livewire/WAService/QRCodeModal.php) | Mengambil QR code dan menampilkannya agar perangkat WhatsApp dapat dipasangkan. |
| [`InspectionRepository`](app/Repositories/Console/InspectionRepository.php) | Membuat dan mengirim pesan notifikasi hasil inspeksi ke grup WhatsApp. |
| [`DashboardController`](app/Http/Controllers/Console/DashboardController.php) | Memeriksa koneksi WhatsApp dan mengirim email peringatan jika koneksi tidak aktif. |
| [`services.php`](config/services.php) | Membaca session ID, API key, dan group ID dari environment. |

Service Whatspie berjalan pada host internal `172.16.10.114:3000`. Aplikasi CMS mengaksesnya menggunakan API key pada header `x-api-key`.

## 2. Konfigurasi yang dibutuhkan

Tambahkan nilai berikut pada file `.env`:

```env
WHATSPIE_SECRET_KEY=isi_api_key_whatspie
WHATSPIE_GROUP_ID=isi_chat_id_grup
SESSION_ID_WA=isi_session_id
```

Nilai tersebut dibaca melalui [`config/services.php`](config/services.php):

- `WHATSPIE_SECRET_KEY`: API key untuk autentikasi ke service Whatspie.
- `WHATSPIE_GROUP_ID`: tujuan pengiriman pesan, yaitu chat ID grup WhatsApp.
- `SESSION_ID_WA`: identitas sesi WhatsApp yang digunakan pada URL API.

Selain itu, database harus memiliki konfigurasi dengan `name` bernilai `whatsapp-notif`. Nilai `status` konfigurasi tersebut menjadi sakelar pengiriman notifikasi inspeksi.

## 3. Alur koneksi perangkat WhatsApp

### 3.1 Melihat status

1. Administrator membuka halaman konfigurasi.
2. [`ButtonAction`](app/Http/Livewire/WAService/ButtonAction.php) memanggil `WhatspieService::getStatus()`.
3. Aplikasi mengirim `GET` ke:

   ```text
   http://172.16.10.114:3000/session/status/{SESSION_ID_WA}
   ```

4. Respons JSON dibaca dan nilai `state` disimpan sebagai status tampilan.
5. Jika respons kosong atau tidak valid, status ditampilkan sebagai `NOT CONNECTED`.
6. Jika status `CONNECTED`, tombol `Terminate` ditampilkan. Selain itu, tombol `Start` ditampilkan.

### 3.2 Memulai sesi dan melakukan pairing

1. Administrator menekan tombol `Start`.
2. Route `console.config.start` memanggil `ConfigController::start_session()`.
3. [`WhatspieService`](app/Services/WhatspieService.php) mengirim `GET` ke:

   ```text
   http://172.16.10.114:3000/session/start/{SESSION_ID_WA}
   ```

4. Jika respons mengandung `success: true`, aplikasi menampilkan pesan agar administrator memindai QR code.
5. Administrator membuka tombol `QRcode`.
6. [`QRCodeModal`](app/Http/Livewire/WAService/QRCodeModal.php) memanggil `fetchQRCode()`, lalu mengirim `GET` ke:

   ```text
   http://172.16.10.114:3000/session/qr/{SESSION_ID_WA}/image
   ```

7. Jika respons berupa gambar, data gambar disimpan dan dirender sebagai base64 pada modal.
8. Administrator memindai QR code menggunakan perangkat WhatsApp.
9. Setelah pairing berhasil, status sesi menjadi `CONNECTED`.

### 3.3 Menghentikan sesi

1. Saat status `CONNECTED`, administrator menekan `Terminate`.
2. Route `console.config.terminate` memanggil `ConfigController::terminate_session()`.
3. Aplikasi mengirim `GET` ke:

   ```text
   http://172.16.10.114:3000/session/terminate/{SESSION_ID_WA}
   ```

4. Pesan hasil operasi ditampilkan kembali pada halaman konfigurasi.

Route start, terminate, dan halaman konfigurasi dibatasi untuk role `Administrator` melalui [`routes/admin.php`](routes/admin.php).

## 4. Alur pengiriman pesan otomatis

Saat ini pengiriman WhatsApp otomatis digunakan pada proses **posting hasil inspeksi**:

1. User mem-posting data inspeksi melalui repository [`InspectionRepository`](app/Repositories/Console/InspectionRepository.php).
2. Aplikasi memastikan inspeksi berstatus `DRAFT` dan memiliki detail container.
3. Status inspeksi diubah menjadi `POSTED`, lalu status container terkait diperbarui.
4. Aplikasi tetap mengirim email notifikasi inspeksi kepada seluruh admin dengan role `SUPERVISOR`.
5. Aplikasi menyusun pesan dengan isi:
   - judul laporan hasil inspeksi CT;
   - nomor inspeksi;
   - lokasi;
   - tanggal dan waktu tindakan;
   - nomor KA;
   - daftar container;
   - deskripsi kerusakan;
   - URL gambar kerusakan.
6. Aplikasi mencari konfigurasi database bernama `whatsapp-notif`.
7. Jika konfigurasi ditemukan dan `status` bernilai aktif, aplikasi memanggil:

   ```php
   $whatspieService->sendMessageToGroup($message);
   ```

8. `WhatspieService` mengirim `POST` ke:

   ```text
   http://172.16.10.114:3000/client/sendMessage/{SESSION_ID_WA}
   ```

   dengan body JSON:

   ```json
   {
     "chatId": "{WHATSPIE_GROUP_ID}",
     "contentType": "string",
     "content": "isi pesan inspeksi"
   }
   ```

9. Jika request berhasil, respons dicatat pada log aplikasi sebagai `WhatsApp message sent successfully`.
10. Jika request gagal, detail error dicatat sebagai error log.

### Diagram singkat

```text
Administrator mem-posting inspeksi
              |
              v
InspectionRepository::posted()
              |
              +--> Kirim email ke Supervisor
              |
              +--> Cek Config(name = whatsapp-notif)
                         |
                status aktif?
                    /       \
                  ya        tidak
                  |           |
                  v           v
       WhatspieService     Tidak kirim WA
       ::sendMessageToGroup()
                  |
                  v
       Whatspie API -> Grup WhatsApp
```

## 5. Pemantauan dan peringatan koneksi

Saat dashboard dibuka, [`DashboardController`](app/Http/Controllers/Console/DashboardController.php) melakukan langkah berikut:

1. Memanggil `WhatspieService::getStatus()`.
2. Membaca konfigurasi `whatsapp-notif`.
3. Jika status tidak ada atau bukan `CONNECTED`, dan konfigurasi sebelumnya aktif:
   - menampilkan pesan `Whatsapp Notification Service: NOT CONNECTED`;
   - mengubah status konfigurasi `whatsapp-notif` menjadi tidak aktif;
   - mengirim email `WhatsappServiceEmail` ke `it@baracoal.com`.
4. Setelah status dinonaktifkan, pengiriman notifikasi inspeksi berikutnya tidak akan memanggil API WhatsApp sampai konfigurasi diaktifkan kembali.

## 6. Penanganan kondisi gagal

- Jika API status tidak dapat diakses, status UI dianggap `NOT CONNECTED`.
- Jika QR code gagal diambil, modal menampilkan pesan error dari service.
- Jika `WHATSPIE_SECRET_KEY` kosong, `sendMessageToGroup()` langsung berhenti tanpa mengirim request.
- Jika API pengiriman mengembalikan error, error dicatat pada log aplikasi.
- Jika konfigurasi `whatsapp-notif` tidak ditemukan atau tidak aktif, pesan WhatsApp tidak dikirim.
- Kegagalan pengiriman pesan tidak melempar error kembali dari `sendMessageToGroup()`; proses pemanggil tetap dapat melanjutkan transaksi setelah error dicatat.

## 7. Cara operasional

1. Pastikan service Whatspie dapat diakses dari server aplikasi.
2. Isi tiga environment variable WhatsApp dan bersihkan cache konfigurasi Laravel jika diperlukan.
3. Buka menu konfigurasi sebagai Administrator.
4. Tekan `Start`.
5. Buka `QRcode`, lalu scan menggunakan perangkat WhatsApp.
6. Pastikan status berubah menjadi `CONNECTED`.
7. Aktifkan konfigurasi `whatsapp-notif`.
8. Post data inspeksi dan periksa:
   - pesan masuk ke grup WhatsApp;
   - log Laravel untuk status request;
   - dashboard jika koneksi terputus.

## 8. Catatan implementasi

- Endpoint Whatspie dan group ID saat ini dikendalikan oleh konfigurasi, tetapi host `172.16.10.114:3000` masih ditulis langsung di [`WhatspieService`](app/Services/WhatspieService.php).
- Pengiriman otomatis yang ditemukan saat ini adalah notifikasi hasil inspeksi. Proses posting progress perbaikan mengirim email, tetapi tidak memanggil pengiriman WhatsApp.
- Tombol pengelolaan sesi hanya tersedia untuk Administrator.
