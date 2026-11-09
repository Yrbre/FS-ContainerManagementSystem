@extends('layouts.console')

@section('title')
    Tambah Config | Console Admin
@endsection

@section('nav')
    <ol class="breadcrumb my-0 ms-2">
        <li class="breadcrumb-item">
            <a href="{{ route('console.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('console.config.index') }}">Config</a>
        </li>
        <li class="breadcrumb-item active"><span>Tambah Config</span></li>
    </ol>
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <div class="my-3">
            @include('partials.alert')
        </div>
    </div>
    <div class="section-body pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Tambah Config</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('console.config.store') }}" method="POST">
                            @csrf
        
                            <div class="row">
                                @include('console.master.config.form')

                                <div class="col-12 col-sm-12 col-md-12 d-flex justify-content-end">
                                    <a href="{{ route('console.config.index') }}" class="btn btn-warning mx-1">Cancel</a>
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
