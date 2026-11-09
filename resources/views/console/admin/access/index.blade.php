@extends('layouts.console')

@section('title')
    Access | Console Admin
@endsection

@section('nav')
    <ol class="breadcrumb my-0 ms-2">
        <li class="breadcrumb-item">
            <a href="{{ route('console.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('console.access.index') }}">Access List</a>
        </li>
        <li class="breadcrumb-item active"><span>Browse Access Lists</span></li>
    </ol>
@endsection

@section('content')
    <section class="card">
        <div class="card-header">
            <div class="col-sm-12">
                @include('console.user.partials.alert')
            </div>
            <strong>Browse Access Lists</strong>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                {{ $dataTable->table(['class' => 'table table-striped']) }}
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush