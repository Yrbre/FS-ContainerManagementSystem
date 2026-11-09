@extends('layouts.console')

@section('title')
    Kelola {{$content_title}} | Console Admin
@endsection

@section('nav')
    <ol class="breadcrumb my-0 ms-2">
        <li class="breadcrumb-item">
            <a href="{{ route('console.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('console.contract.index') }}">{{$content_title}}</a>
        </li>
        <li class="breadcrumb-item active"><span>Data {{$content_title}}</span></li>
    </ol>
@endsection

@section('content')
        <div class="card mb-5">
            <div class="card-header">
                <div class="col-sm-12">
                </div>
                <strong>Kelola {{$content_title}}</strong>
            </div>
            <div class="card-body">
                @include('partials.alert')
                <div class="table-responsive">
                    {{ $dataTable->table(['class' => 'table table-stripped']) }}
                </table>
            </div>
        </div>

@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush

