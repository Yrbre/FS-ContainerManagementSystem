@component('mail::message')
# Hi, 

Laporan progress perbaikan harian dengan kode transaksi <strong>{{ $containerRepair->code }}</strong> telah di <strong>Reject</strong>
@component('mail::button', ['url' => route('console.container-repair.detail', $containerRepair), 'color' => 'success'])
Lihat Inspeksi
@endcomponent

@endcomponent
