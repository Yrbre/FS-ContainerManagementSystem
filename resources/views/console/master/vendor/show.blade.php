@extends('layouts.console')

@section('title')
    Detail Vendor
@endsection

@section('nav')
    <ol class="breadcrumb my-0 ms-2">
        <li class="breadcrumb-item">
            <a href="{{ route('console.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('console.vendor.index') }}">Vendor</a>
        </li>
        <li class="breadcrumb-item active"><span>Detail Vendor</span></li>
    </ol>
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="my-3">
                @include('partials.alert')
            </div>
        </div>
        <div class="section-body mb-5">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="row mb-2">
                        <div class="col-sm-2">
                            <a href="{{ route('console.vendor.index') }}" class="btn-success btn btn-xs">
                                <i class="fas fa-arrow-left"></i>
                                back
                            </a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5>Detail Vendor</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Kode ERP</label>
                                        <input class="form-control" type="text" value="{{ $vendor->erp_code }}" readonly />
                                    </div>
        
                                    <div class="form-group">
                                        <label>Nama Lokasi</label>
                                        <input class="form-control" type="text" value="{{ $vendor->name }}" readonly />
                                    </div>

                                    <div class="form-group">
                                        <label>Dibuat Oleh</label>
                                        <input class="form-control" type="text" value="{{ $vendor->admin->name }}" readonly />
                                    </div>

                                    <div class="form-group">
                                        <label>Dibuat Pada</label>
                                        <input class="form-control" type="text" value="{{ $vendor->created_at ? \Carbon\Carbon::parse($vendor->created_at) : '' }}" readonly />
                                    </div>

                                    <div class="form-group">
                                        <label>Alamat 1</label>
                                        <textarea class="form-control" readonly>{{ $vendor->address_1 }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Alamat 2</label>
                                        <textarea class="form-control" readonly>{{ $vendor->address_2 }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Alamat 3</label>
                                        <textarea class="form-control" readonly>{{ $vendor->address_3 }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('console.vendor.index') }}" class="btn-success btn btn-xs">
                                <i class="fas fa-arrow-left"></i>
                                back
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
