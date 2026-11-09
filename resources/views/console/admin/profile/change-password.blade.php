@extends('layouts.console')
@section('title')
    Change Password | Console Admin
@endsection

@section('nav')
    <ol class="breadcrumb my-0 ms-2">
        <li class="breadcrumb-item">
            <a href="{{ route('console.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#">Profile</a>
        </li>
        <li class="breadcrumb-item active"><span>Ubah Password</span></li>
    </ol>
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <div class="row justify-content-center my-3">
            <div class="col-sm-6">
                @include('partials.alert') 
            </div>
        </div>
    </div>
    <div class="section-body">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Ubah Password</h5>
                    </div>

                    
                    <div class="card-body">
                        <form action="{{ route('console.profile.change.password.update', $admin->id) }}" method="POST">
                            @csrf
                            @method('PUT')
        
                            <div class="row">
                                <div class="col-sm-12 col-12 col-md-12">
                                    <div class="form-group mb-3">
                                        <label for="new_password">Kata sandi lama</label>
                                        <div class="input-group">
                                            <input  class="form-control @error('old_password') is-invalid @enderror" name="old_password" type="password" placeholder="Kata sandi lama">
                                            <div class="input-group-addon">
                                                <button class="btn btn-secondary">
                                                    <i class="fas fa-lock"></i>
                                                </button>
                                            </div>
                                            @error('old_password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="new_password">Kata sandi baru</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Kata sandi baru">
                                            <div class="input-group-addon">
                                                <button class="btn btn-secondary">
                                                    <i class="fas fa-lock"></i>
                                                </button>
                                            </div>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="password_confirmation">Konfirmasi kata sandi baru</label>
                                        <div class="input-group mb-3">
                                            <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" placeholder="Konfirmasi kata sandi" required>
                                            <div class="input-group-addon">
                                                <span class="btn btn-secondary">
                                                    <i class="fas fa-lock"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
        
                                <div class="col-12 col-sm-12 col-md-12 d-flex justify-content-end">
                                    <a href="{{ route('console.dashboard') }}" class="btn btn-warning mx-1">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
