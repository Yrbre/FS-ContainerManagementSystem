@component('mail::message')
# Hi, 

Berita Acara Serah Terima ke Vendor dengan kode transaksi <strong>{{ $containerDelegation->code }}</strong> menunggu persetujuan anda. Klik tombol dibawah untuk melihat detail nya
@component('mail::button', ['url' => route('console.delegation-to-vendor.detail', $containerDelegation), 'color' => 'success'])
Lihat BAST
@endcomponent

@endcomponent
