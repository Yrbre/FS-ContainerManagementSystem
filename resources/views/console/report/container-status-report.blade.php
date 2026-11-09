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
            <a href="{{ route('console.report.container-status-report') }}">Laporan</a>
        </li>
        <li class="breadcrumb-item active"><span>CT Status Report</span></li>
    </ol>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            Container Status Report
        </div>
        <div class="card-body">
            <livewire:report.container-report.table-section/>
        </div>
    </div>
@endsection



