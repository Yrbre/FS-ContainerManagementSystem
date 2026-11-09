@component('mail::message')
# Hi, 

Laporan inspeksi harian dengan kode transaksi <strong>{{ $inspection->code }}</strong> menunggu persetujuan anda. Klik tombol dibawah untuk melihat detail nya
@component('mail::button', ['url' => route('console.inspection.detail', $inspection), 'color' => 'success'])
Lihat Inspeksi
@endcomponent

@endcomponent
