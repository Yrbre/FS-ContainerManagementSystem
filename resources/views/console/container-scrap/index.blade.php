@extends('layouts.console')

@section('title')
    Kelola Proses Scrap CT
@endsection

@section('nav')
    <ol class="breadcrumb my-0 ms-2">
        <li class="breadcrumb-item">
            <a href="{{ route('console.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('console.container-scrap.index') }}">Proses Scrap CT</a>
        </li>
        <li class="breadcrumb-item active"><span>Data Proses Scrap CT</span></li>
    </ol>
@endsection

@section('content')

    <div class="card mb-5">
        <div class="card-header">
            <div class="col-sm-12">
                @include('partials.alert')
            </div>
            <strong>Kelola Proses Scrap CT</strong>
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

