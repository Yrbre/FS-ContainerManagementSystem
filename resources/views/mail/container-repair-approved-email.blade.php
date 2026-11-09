@component('mail::message')
# Hi, 

Laporan Progress harian dengan kode transaksi <strong>{{ $containerRepair->code }}</strong> telah di <strong>Approve</strong> oleh <span class="text-info">{{$containerRepair->approveBy->name}}</span>
@component('mail::button', ['url' => route('console.container-repair.detail', $containerRepair), 'color' => 'success'])
Lihat Inspeksi
@endcomponent

@endcomponent
