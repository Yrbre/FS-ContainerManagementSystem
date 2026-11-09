@extends('layouts.console')

@section('title')
    Buat BAST CT ke Vendor Baru
@endsection

@section('nav')
    <ol class="breadcrumb my-0 ms-2">
        <li class="breadcrumb-item">
            <a href="{{ route('console.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('console.delegation-to-vendor.index') }}">Berita Serah Terima CT ke Vendor</a>
        </li>
        <li class="breadcrumb-item active"><span>Buat BAST CT Ke Vendor Baru</span></li>
    </ol>
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <div class="my-3">
            @include('partials.alert')
        </div>
    </div>
    <div class="section-body pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Tambah BAST ke Vendor</h5>
                    </div>
                    <div class="card-body">
                        @livewire('container-delegation-to-vendor.form-create')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
