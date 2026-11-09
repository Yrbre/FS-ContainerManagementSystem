@extends('layouts.console')

@section('title')
    Rekap BAST Maintenance
@endsection

@section('nav')
    <ol class="breadcrumb my-0 ms-2">
        <li class="breadcrumb-item">
            <a href="{{ route('console.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('console.bast.maintenance') }}">Laporan</a>
        </li>
        <li class="breadcrumb-item active"><span>Rekap BAST</span></li>
    </ol>
@endsection

@section('content')
    @php extract($_GET); @endphp

    <!-- Form -->
    <div class="card">
        <div class="card-header">
            <h4 class="m-0">Filter Rekap</h4>
        </div>
        <div class="card-body">
            <livewire:report.filter-bast />
        </div>
    </div>
    <!-- End Form -->
    @if ($showTableFilter)
        <div class="card mt-4">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-12">
                        @include('partials.alert')
                    </div>
                </div>
                <h4>Rekap BAST</h4>
            </div>

            <div class="card-body">
                Ditemukan <strong>#{{count($results->groupBy('container_code'))}} data</strong>
                <div class="table-responsive">
                    @if($params['by_type'] == "Maintenance")
                        @include('console.report.bast.maintenance-table')
                    @else
                        @include('console.report.bast.upgrade-table')
                    @endif
                </div>
            </div>
        </div>
    @endif

@endsection

@push('scripts')
@endpush
