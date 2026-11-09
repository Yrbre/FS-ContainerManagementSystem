@extends('layouts.console')

@section('title')
    Edit Proses Scrap CT
@endsection

@section('nav')
    <ol class="breadcrumb my-0 ms-2">
        <li class="breadcrumb-item">
            <a href="{{ route('console.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('console.container-scrap.index') }}">Proses Scrap CT</a>
        </li>
        <li class="breadcrumb-item active"><span>Edit Proses Scrap CT</span></li>
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
                        <h5>Edit Proses Scrap CT</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('console.container-scrap.update', $ctScrap) }}" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
        
                            <div class="row">
                                @include('console.container-scrap.form')
        
                                <div class="col-12 col-sm-12 col-md-12 d-flex justify-content-end">
                                    <a href="{{ route('console.container-scrap.index') }}" class="btn btn-outline-primary text-dark mr-2">Cancel</a>
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
