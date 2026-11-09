@component('mail::message')
# Hi, 

Laporan inspeksi harian dengan kode transaksi <strong>{{ $inspection->code }}</strong> telah di <strong>Reject</strong>
@component('mail::button', ['url' => route('console.inspection.detail', $inspection), 'color' => 'success'])
Lihat Inspeksi
@endcomponent

@endcomponent
