@extends('layouts.console')

@section('title')
    Tambah {{$content_title}} | Console Admin
@endsection

@section('nav')
    <ol class="breadcrumb my-0 ms-2">
        <li class="breadcrumb-item">
            <a href="{{ route('console.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('console.admin.index') }}">{{$content_title}}</a>
        </li>
        <li class="breadcrumb-item active"><span>Tambah {{$content_title}}</span></li>
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
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Tambah {{$content_title}}</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('console.admin.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
        
                            <div class="row">
                                @include('console.master.admin.form')
        
                                <div class="col-12 col-sm-12 col-md-12">
                                    <a href="{{ route('console.admin.index') }}" class="btn btn-outline-primary text-dark mr-2">Cancel</a>
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
