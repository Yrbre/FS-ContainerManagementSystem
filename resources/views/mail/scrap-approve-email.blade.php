@component('mail::message')
# Hi, 

Proses Scrap Container dengan kode transaksi <strong>{{ $containerScrap->code }}</strong> telah di <strong>Approve</strong> oleh <span class="text-info">{{ $containerScrap->lastUpdatedBy->name }}</span>
@component('mail::button', ['url' => route('console.container-scrap.detail', $containerScrap), 'color' => 'success'])
Lihat Detail Scrap
@endcomponent

@endcomponent
