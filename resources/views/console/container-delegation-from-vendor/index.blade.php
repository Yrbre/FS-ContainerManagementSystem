@extends('layouts.console')

@section('title')
    Kelola BAST Dari Vendor
@endsection

@section('nav')
    <ol class="breadcrumb my-0 ms-2">
        <li class="breadcrumb-item">
            <a href="{{ route('console.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('console.delegation-from-vendor.index') }}">Berita Serah Terima CT Dari Vendor</a>
        </li>
        <li class="breadcrumb-item active"><span>Data Berita Serah Terima CT Dari Vendor</span></li>
    </ol>
@endsection

@section('content')

    <div class="card mb-5">
        <div class="card-header">
            <div class="col-sm-12">
                @include('partials.alert')
            </div>
            <strong>Kelola Serah Terima CT Dari Vendor</strong>
        </div>
        <div class="card-body mb-5">
        <div class="table-responsive">
                {{ $dataTable->table(['class' => 'table table-stripped']) }}
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush

