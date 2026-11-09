@extends('layouts.console')

@section('title')
    Kelola Progress Perbaikan
@endsection

@section('nav')
    <ol class="breadcrumb my-0 ms-2">
        <li class="breadcrumb-item">
            <a href="{{ route('console.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('console.container-repair.index') }}">Progress Harian</a>
        </li>
        <li class="breadcrumb-item active"><span>Kelola Progress Perbaikan</span></li>
    </ol>
@endsection

@section('content')

    <div class="card mb-5">
        <div class="card-header">
            <div class="col-sm-12">
                @include('partials.alert')
            </div>
            <strong>Kelola Progress Perbaikan</strong>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                {{ $dataTable->table(['class' => 'table table-stripped']) }}
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush

