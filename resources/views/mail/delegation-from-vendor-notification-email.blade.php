@component('mail::message')
# Hi, 

Berita Acara Serah Terima dari Vendor dengan kode transaksi <strong>{{ $containerDelegationFromVendor->code }}</strong> menunggu persetujuan anda. Klik tombol dibawah untuk melihat detail nya
@component('mail::button', ['url' => route('console.delegation-from-vendor.detail', $containerDelegationFromVendor), 'color' => 'success'])
Lihat BAST
@endcomponent

@endcomponent
