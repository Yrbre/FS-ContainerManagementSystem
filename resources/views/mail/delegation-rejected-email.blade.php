@component('mail::message')
# Hi, 

Berita Acara Serah Terima ke Vendor  dengan kode transaksi <strong>{{ $containerDelegation->code }}</strong> telah di <strong>Reject</strong> oleh <span class="text-info">{{ $containerDelegation->lastUpdatedBy->name }}</span>
@component('mail::button', ['url' => route('console.delegation-to-vendor.detail', $containerDelegation), 'color' => 'success'])
Lihat BAST
@endcomponent

@endcomponent
