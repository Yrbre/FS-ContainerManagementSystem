@extends('layouts.console')

@section('title')
    Detail Lokasi
@endsection

@section('nav')
    <ol class="breadcrumb my-0 ms-2">
        <li class="breadcrumb-item">
            <a href="{{ route('console.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('console.location.index') }}">Lokasi</a>
        </li>
        <li class="breadcrumb-item active"><span>Detail Lokasi</span></li>
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
                            <a href="{{ route('console.location.index') }}" class="btn-success btn btn-xs">
                                <i class="fas fa-arrow-left"></i>
                                back
                            </a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5>Detail Lokasi</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Kode Lokasi</label>
                                        <input class="form-control" type="text" value="{{ $location->code }}" readonly />
                                    </div>
        
                                    <div class="form-group">
                                        <label>Nama Lokasi</label>
                                        <input class="form-control" type="text" value="{{ $location->name }}" readonly />
                                    </div>

                                    <div class="form-group">
                                        <label>Dibuat Oleh</label>
                                        <input class="form-control" type="text" value="{{ $location->admin->name }}" readonly />
                                    </div>

                                    <div class="form-group">
                                        <label>Dibuat Pada</label>
                                        <input class="form-control" type="text" value="{{ $location->created_at ? \Carbon\Carbon::parse($location->created_at) : '' }}" readonly />
                                    </div>

                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <textarea class="form-control" readonly>{{ $location->address }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
