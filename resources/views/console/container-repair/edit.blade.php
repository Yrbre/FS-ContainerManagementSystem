@extends('layouts.console')

@section('title')
    Edit Progress Harian
@endsection

@section('nav')
    <ol class="breadcrumb my-0 ms-2">
        <li class="breadcrumb-item">
            <a href="{{ route('console.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('console.container-repair.index') }}">Progress Harian</a>
        </li>
        <li class="breadcrumb-item active"><span>Edit Progress Harian</span></li>
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
                        <h5>Edit Progress Harian</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('console.container-repair.update', $containerRepair->id) }}" method="POST">
                            @method('PUT')
                            @csrf
        
                            <div class="row">
                                @include('console.container-repair.form')
                                <div class="col-12 col-sm-12 col-md-12 d-flex justify-content-end">
                                    <a href="{{ route('console.container-repair.index') }}" class="btn btn-outline-primary text-dark mr-2">Cancel</a>
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
