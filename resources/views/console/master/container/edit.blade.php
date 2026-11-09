@extends('layouts.console')

@section('title')
    Edit Kontainer | Console Admin
@endsection

@section('nav')
    <ol class="breadcrumb my-0 ms-2">
        <li class="breadcrumb-item">
            <a href="{{ route('console.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('console.container.index') }}">Kontainer</a>
        </li>
        <li class="breadcrumb-item active"><span>Edit Kontainer</span></li>
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
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Edit Kontainer</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('console.container.update', $container->code) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            @include('console.master.container.form')
        
                            <div class="form-group">
                                <a href="{{ route('console.container.index') }}" class="btn btn-outline-primary text-dark mr-2">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
