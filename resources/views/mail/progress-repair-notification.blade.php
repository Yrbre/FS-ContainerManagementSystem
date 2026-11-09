@component('mail::message')
# Hi, 

Laporan Progress perbaikan harian  dengan kode transaksi <strong>{{ $containerRepair->code }}</strong> menunggu persetujuan anda. Klik tombol dibawah untuk melihat detail nya
@component('mail::button', ['url' => route('console.container-repair.detail', $containerRepair), 'color' => 'success'])
Lihat Laporan Progress 
@endcomponent

@endcomponent
