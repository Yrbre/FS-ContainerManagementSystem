@extends('layouts.console')

@section('title')
    Kelola Kontainer
@endsection

@section('nav')
    <ol class="breadcrumb my-0 ms-2">
        <li class="breadcrumb-item">
            <a href="{{ route('console.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('console.container.index') }}">Kontainer</a>
        </li>
        <li class="breadcrumb-item active"><span>Data Kontainer</span></li>
    </ol>
@endsection

@section('content')

    <div class="card mb-5">
        <div class="card-header">
            <div class="col-sm-12">
                @include('partials.alert')
            </div>
            <strong>Kelola Kontainer</strong>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    {{ $dataTable->table(['class' => 'table table-stripped']) }}
                </table>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush

