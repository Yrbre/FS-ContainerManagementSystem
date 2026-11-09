@extends('layouts.console')

@section('title')
    Container Dashboard
@endsection

@section('nav')
    <ol class="breadcrumb my-0 ms-2">
        <li class="breadcrumb-item">
            <a href="{{ route('console.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('console.report.container-dashboard') }}">Laporan</a>
        </li>
        <li class="breadcrumb-item active"><span>CT Dashboard</span></li>
    </ol>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            Container Status Dashboard
        </div>
        <div class="card-body">
            <livewire:container-dashboard.table-section/>
        </div>
    </div>
@endsection


