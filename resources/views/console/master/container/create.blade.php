@extends('layouts.console')

@section('title')
    Tambah Kontainer
@endsection

@section('nav')
    <ol class="breadcrumb my-0 ms-2">
        <li class="breadcrumb-item">
            <a href="{{ route('console.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('console.container.index') }}">Kontainer</a>
        </li>
        <li class="breadcrumb-item active"><span>Tambah Kontainer</span></li>
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
                            <h5>Tambah Kontainer</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('console.container.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                
                                @include('console.master.container.form')

                                <div class="form-group">
                                <a href="{{ route('console.container.index') }}" class="btn btn-outline-primary text-dark mr-2">Cancel</a>
                                <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
