@component('mail::message')
# Hi, 

Berita Acara Serah Terima dari Vendor  dengan kode transaksi <strong>{{ $containerDelegationFromVendor->code }}</strong> telah di <strong>Reject</strong> oleh <span class="text-info">{{ $containerDelegationFromVendor->lastUpdatedBy->name }}</span>
@component('mail::button', ['url' => route('console.delegation-from-vendor.detail', $containerDelegationFromVendor), 'color' => 'success'])
Lihat BAST
@endcomponent

@endcomponent
