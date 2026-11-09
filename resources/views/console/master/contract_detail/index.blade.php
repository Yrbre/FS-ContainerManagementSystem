@extends('layouts.console')

@section('title')
    Kelola {{ $content_title }} | Console Admin
@endsection

@section('nav')
    <ol class="breadcrumb my-0 ms-2">
        <li class="breadcrumb-item">
            <a href="{{ route('console.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('console.contract.index') }}">Kontrak</a>
        </li>
        <li class="breadcrumb-item active"><span>Data {{ $content_title }}</span></li>
    </ol>
@endsection

@section('content')
    <div class="section-header">
        <div class="my-3">
            @include('partials.alert')
        </div>
    </div>

    <div class="seaction-body mb-5">

        <div class="row">
            <div class="col-sm-3 mb-2">
                <a href="{{ route('console.contract.index') }}" class="btn-success btn btn-xs">
                    <i class="fas fa-arrow-left"></i>
                    back
                </a>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Kontrak {{ $contract->code }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="font-weight-bold m-0">Nomor Transaksi</label>
                            <p>{{ $contract->code }}</p>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold m-0">Tipe Kontrak</label>
                            <p>{{ $contract->type }}</p>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold m-0">Subject</label>
                            <p>{{ $contract->subject }}</p>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold m-0">Status</label>
                            <p>{{ $contract->status }}</p>
                        </div>
                        <hr class="border border-primary">
                        <div class="form-group">
                            <label class="font-weight-bold m-0">Vendor</label>
                            <p>{{ $contract->vendor->name }}</p>
                        </div>
                        <div class="form-group row">
                            <label class="font-weight-bold m-0">Tanggal & Waktu Masa Berlaku</label>
                            <div class="col-sm-6">
                                <p>{{ \Carbon\Carbon::parse($contract->active_date_start)->format('d-m-Y') }} s/d
                                    {{ \Carbon\Carbon::parse($contract->active_date_end)->format('d-m-Y') }}</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="font-weight-bold m-0">Masa Garansi</label>
                            {{-- <div class="col-sm-4">
                            <label for="">Tanggal Dan waktu</label>
                            @if ($contract->warranty_date_start) 
                            <p>{{ \Carbon\Carbon::parse($contract->waranty_date_start)->format('d-m-Y') }} s/d {{ \Carbon\Carbon::parse($contract->waranty_date_end)->format('d-m-Y') }}</p>
                            @else
                            -
                            @endif

                        </div> --}}
                            <div class="col-sm-4">
                                <label for="">Dalam bulan</label>
                                <p>{{ $contract->warranty_in_month ?? '-' }}</p>

                            </div>
                            <div class="col-sm-4">
                                <label for="">Dalam hari</label>
                                <p>{{ $contract->warranty_in_days ?? '-' }}</p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            {{ $dataTable->table(['class' => 'table table-stripped']) }}
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    @endsection

    @push('scripts')
        {{ $dataTable->scripts() }}
    @endpush
