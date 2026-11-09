@component('mail::message')
# Hi, 

Proses Scrap Container dengan kode transaksi <strong>{{ $containerScrap->code }}</strong> menunggu persetujuan anda. Klik tombol dibawah untuk melihat detail nya
@component('mail::button', ['url' => route('console.container-scrap.detail', $containerScrap), 'color' => 'success'])
Lihat Detail Scrap
@endcomponent

@endcomponent
