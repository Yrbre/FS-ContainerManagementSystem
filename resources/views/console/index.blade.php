@extends('layouts.console')

@section('title')
    Dashboard | Console Admin
@endsection


@section('nav')
    <ol class="breadcrumb my-0 ms-2">
        <li class="breadcrumb-item">
            <a href="{{ route('console.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('console.dashboard') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item active"><span>Admin Summary</span></li>
    </ol>
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h5>Admin Summary Dashboard</h5>
        </div>

        
        <div class="card-body">
            @if ($alertMessage)
                <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                    {{ $alertMessage }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
            @endif
            <livewire:dashboard.main-section />
        </div>
    </section>
@endsection
