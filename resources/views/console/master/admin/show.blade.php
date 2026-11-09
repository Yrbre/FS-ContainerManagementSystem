@extends('layouts.console')

@section('title')
    Detail User
@endsection

@section('nav')
    <ol class="breadcrumb my-0 ms-2">
        <li class="breadcrumb-item">
            <a href="{{ route('console.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('console.admin.index') }}">User</a>
        </li>
        <li class="breadcrumb-item active"><span>Detail User</span></li>
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
            <div class="row mb-2">
                <div class="col-sm-2">
                    <a href="{{ route('console.admin.index') }}" class="btn-success btn btn-xs">
                        <i class="fas fa-arrow-left"></i>
                        back
                    </a>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Detail User</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input class="form-control" type="text" value="{{ $admin->name }}" readonly />
                                    </div>
        
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input class="form-control" type="text"value="{{ $admin->email }}" readonly />
                                    </div>
        
                                    <div class="form-group">
                                        <label>Role</label>
                                        <input type="text" class="form-control" value="{{ $admin->role }}" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label>Tanggal Ditambahkan</label>
                                        <input type="text" class="form-control" value="{{ $admin->created_at ? \Carbon\Carbon::parse($admin->created_at)->format('d-m-Y H:i:s') : '' }}" readonly>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Tanda Tangan</label>
                                        <img src="{{ $admin->signature ? Storage::url($admin->signature) : 'https://placehold.co/600x300?text=Tidak+Mempunyai+Tanda+Tangan' }}" alt="" style="width: 100%; height: 100%; object-fit: cover; object-position: center;">
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
