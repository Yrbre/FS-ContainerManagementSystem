@extends('layouts.console')

@section('title')
    Buat Progress Harian Baru
@endsection

@section('nav')
    <ol class="breadcrumb my-0 ms-2">
        <li class="breadcrumb-item">
            <a href="{{ route('console.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('console.container-repair.index') }}">Progress Harian</a>
        </li>
        <li class="breadcrumb-item active"><span>Buat Progress Harian Baru</span></li>
    </ol>
@endsection

@section('content')
    {{-- Start Modal --}}
    <!-- Modal -->
    <div class="modal fade" id="addDetailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            {{-- <livewire:inspection.form-detail inspectionId="{{ $containerRepair->id }}"/> --}}
        </div>
    </div>
    {{-- End Modal --}}
    <section class="section">
        <div class="section-header">
            <div class="my-3">
                @include('partials.alert')
            </div>
        </div>
        <div class="section-body pb-5">
            <div class="row mb-2">
                <div class="col-sm-3">
                    <a href="{{ route('console.container-repair.index') }}" class="btn-success btn btn-xs">
                        <i class="fas fa-arrow-left"></i>
                        back
                    </a>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5>Perbaikan {{ $containerRepair->code }}</h5>
                            <div class="d-flex justify-content-center">
                                @can(['Checker'])
                                    @if($containerRepair->status == "DRAFT")
                                        <form id="posted-form" action="{{ route('console.container-repair.posted', $containerRepair) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">POST</button>
                                        </form>
                                    @endif    
                                @endcan
                                @can(['Supervisor'])
                                    @if($containerRepair->status == "POSTED")
                                        <form id="approved-form" action="{{route('console.container-repair.approve', $containerRepair->id)}}" method="post">
                                            @method('PUT')
                                            @csrf
                                            <button type="submit"  class="btn btn-info mx-1" onclick="return confirm('Yakin mau approve progress ini?')">Approve</button>
                                        </form>
                                        
                                        <form id="approved-form" action="{{route('console.container-repair.reject', $containerRepair->id)}}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn  btn-danger">Reject</button>
                                        </form>
                                    @endif
                                @endcan
                                
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group m-0">
                                        <label class="font-weight-bold m-0">Nomor Transaksi</label>
                                        <input class="form-control-plaintext" value="{{ $containerRepair->code }}" />
                                    </div>
                                    <div class="form-group m-0">
                                        <label class="font-weight-bold m-0">Vendor</label>
                                        <input class="form-control-plaintext" value="{{ $containerRepair->vendor->name }}" />
                                    </div>
                                    <div class="form-group m-0">
                                        <label class="font-weight-bold m-0">Lokasi</label>
                                        <input class="form-control-plaintext" value="{{ $containerRepair->location->code }}" />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-0">
                                        <label class="font-weight-bold m-0">Tanggal & Waktu</label>
                                        <input class="form-control-plaintext" value="{{ $containerRepair->action_date->format('d-m-Y H:i:s') }}" />
                                    </div>
                                    <div class="form-group m-0">
                                        <label class="font-weight-bold m-0">Status</label>
                                        <input class="form-control-plaintext" value="{{ $containerRepair->status }}" />
                                    </div>
                                    <div class="form-group m-0">
                                        <label class="font-weight-bold m-0">Keterangan</label>
                                        <input class="form-control-plaintext" value="{{ $containerRepair->description }}" />
                                    </div>
                                </div>
                            </div>
                            
                            
                        </div>
                    </div>

                    <div class="card mt-2">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5>Daftar container maintenance/repair</h5>
                        </div>
                        <livewire:container-repair.container-repair-progress :containerRepair="$containerRepair" />
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