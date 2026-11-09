@extends('layouts.console')

@section('title')
    Edit BAST CT dari Vendor
@endsection

@section('nav')
    <ol class="breadcrumb my-0 ms-2">
        <li class="breadcrumb-item">
            <a href="{{ route('console.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('console.delegation-to-vendor.index') }}">Berita Serah Terima CT Dari Vendor</a>
        </li>
        <li class="breadcrumb-item active"><span>Edit BAST CT Dari Vendor</span></li>
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
                        <h5>Edit BAST CT Dari Vendor</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('console.delegation-from-vendor.update', $delegationFromVendor->id) }}" method="POST">
                            @method('PUT')
                            @csrf
        
                            <div class="row">
                                @include('console.container-delegation-from-vendor.form')
        
                                <div class="col-12 col-sm-12 col-md-12 d-flex justify-content-end">
                                    <a href="{{ route('console.delegation-from-vendor.index') }}" class="btn btn-outline-primary text-dark mr-2">Cancel</a>
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
