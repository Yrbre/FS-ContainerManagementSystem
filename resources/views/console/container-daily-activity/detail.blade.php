@extends('layouts.console')

@section('title')
    Detail Laporan Aktivitas Harian
@endsection

@section('nav')
    <ol class="breadcrumb my-0 ms-2">
        <li class="breadcrumb-item">
            <a href="{{ route('console.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('console.container-daily-activity.index') }}">Laporan Aktivitas Kontainer</a>
        </li>
        <li class="breadcrumb-item active"><span>Detail Laporan Aktivitas Harian</span></li>
    </ol>
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="my-3">
                @include('partials.alert')
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-3">
                <a href="{{ route('console.container-daily-activity.index') }}" class="btn-success btn btn-xs">
                    <i class="fas fa-arrow-left"></i>
                    back
                </a>
            </div>
        </div>
        <div class="section-body pb-5">
            <div class="row justify-content-center">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5>Aktivitas Harian {{ $containerDailyActivity->code }}</h5>
                            @can(['Checker'])    
                                <div>
                                    @if ($containerDailyActivity->status == 'DRAFT')    
                                        <form id="posted-form" action="{{ route('console.container-daily-activity.posted', $containerDailyActivity) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">POST</button>
                                        </form>
                                    @endif
                                </div>
                            @endcan
                        </div>
                        <div class="card-body row">
                            <div class="col-lg-6">
                                <div class="form-group m-0 px-0 py-1">
                                    <label class="font-weight-bold m-0 p-0">Nomor Transaksi</label>
                                    <input class="form-control-plaintext m-0 p-0 " value="{{ $containerDailyActivity->code }}" />
                                </div>
                                <div class="form-group m-0 px-0 py-1">
                                    <label class="font-weight-bold m-0 p-0">Lokasi</label>
                                    <input class="form-control-plaintext m-0 p-0" value="{{ $containerDailyActivity->location->code .' (' .$containerDailyActivity->location->name. ')' }} " />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-0 px-0 py-1">
                                    <label class="font-weight-bold m-0 p-0">Tanggal & Waktu</label>
                                    <input class="form-control-plaintext m-0 p-0" value="{{ Carbon\Carbon::parse($containerDailyActivity->action_date)->format('d-m-Y H:i:s') }}" />
                                </div>
                                <div class="form-group m-0 px-0 py-1">
                                    <label class="font-weight-bold m-0 p-0">Status</label>
                                    <input class="form-control-plaintext m-0 p-0" value="{{ $containerDailyActivity->status }}" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-2">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5>Detail Laporan Aktivitas Harian</h5>
                            @can(['Checker'])
                                @if ($containerDailyActivity->status == 'DRAFT')
                                    <livewire:container-daily-activity.form-detail containerDailyActivityId="{{ $containerDailyActivity->id }}" :location="$containerDailyActivity->location->code" />
                                @endif
                            @endcan
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <livewire:container-daily-activity.table-daily-activity-detail containerDailyActivityId="{{ $containerDailyActivity->id }}" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(function(){
            $('#posted-form').on('submit', function(e){
                
                if(confirm('Apakah anda yakin?')) {

                }else{
                    e.preventDefault();    
                }
            });
        });
    </script>
@endpush