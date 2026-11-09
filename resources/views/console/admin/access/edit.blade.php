@extends('layouts.console')

@section('title')
    Edit Admin | Console Admin
@endsection

@section('nav')
    <ol class="breadcrumb my-0 ms-2">
        <li class="breadcrumb-item">
            <a href="{{ route('console.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('console.access.index') }}">Access Lists</a>
        </li>
        <li class="breadcrumb-item active"><span>Edit Admin</span></li>
    </ol>
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <div class="row justify-content-center my-3">
            <div class="col-sm-6">
                @include('console.user.partials.alert')
            </div>
        </div>
    </div>
    <div class="section-body">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Edit Admin</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('console.access.update', $admin->id) }}" method="POST">
                            @csrf
                            @method('PUT')
        
                            <div class="row">
                                @include('console.admin.access.form')
        
                                <div class="col-12 col-sm-12 col-md-12">
                                    <button type="submit" class="btn btn-primary">Update</button>
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
