@extends('layouts.console')

@section('title')
    Edit BAST CT ke Vendor
@endsection

@section('nav')
    <ol class="breadcrumb my-0 ms-2">
        <li class="breadcrumb-item">
            <a href="{{ route('console.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('console.delegation-to-vendor.index') }}">Berita Serah Terima CT ke Vendor</a>
        </li>
        <li class="breadcrumb-item active"><span>Edit BAST CT Ke Vendor</span></li>
    </ol>
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <div class="my-3">
            @include('partials.alert')
        </div>
    </div>
    <div class="section-body">
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Edit BAST CT ke Vendor</h5>
                    </div>
                    <div class="card-body">
                        @livewire('container-delegation-to-vendor.form-edit', [
                            'containerDelegation' => $containerDelegation
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
