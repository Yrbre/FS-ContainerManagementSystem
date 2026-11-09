@extends('layouts.console')

@section('title')
    Detail Config
@endsection

@section('nav')
    <ol class="breadcrumb my-0 ms-2">
        <li class="breadcrumb-item">
            <a href="{{ route('console.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('console.config.index') }}">Config</a>
        </li>
        <li class="breadcrumb-item active"><span>Detail Config</span></li>
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
                            <a href="{{ route('console.config.index') }}" class="btn-success btn btn-xs">
                                <i class="fas fa-arrow-left"></i>
                                back
                            </a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5>Detail Config</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Nama Config</label>
                                        <input class="form-control" type="text" value="{{ $config->name }}" readonly />
                                    </div>

                                    <div class="form-group">
                                        <label>Status Config</label>
                                        <input class="form-control" type="text"
                                            value="{{ $config->status ? 'Active' : 'Non-active' }}" readonly />
                                    </div>

                                    <div class="form-group">
                                        <label>Dibuat Pada</label>
                                        <input class="form-control" type="text"
                                            value="{{ $config->created_at ? \Carbon\Carbon::parse($config->created_at) : '' }}"
                                            readonly />
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
