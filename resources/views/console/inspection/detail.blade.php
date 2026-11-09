@extends('layouts.console')

@section('title')
    Buat Inspeksi Harian Baru
@endsection

@section('nav')
    <ol class="breadcrumb my-0 ms-2">
        <li class="breadcrumb-item">
            <a href="{{ route('console.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('console.inspection.index') }}">Inspeksi</a>
        </li>
        <li class="breadcrumb-item active"><span>Buat Inspeksi Harian Baru</span></li>
    </ol>
@endsection

@section('content')
    {{-- Start Modal --}}
    <!-- Modal -->
    <div class="modal fade" id="editDetailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <livewire:inspection.form-detail inspectionId="{{ $inspection->id }}" :location="$inspection->location->code"/>
        </div>
    </div>

    <div class="modal fade" id="addDetailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <livewire:inspection.form-detail inspectionId="{{ $inspection->id }}" :location="$inspection->location->code"/>
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
                    <a href="{{ route('console.inspection.index') }}" class="btn-success btn btn-xs">
                        <i class="fas fa-arrow-left"></i>
                        back
                    </a>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5>Inspeksi {{ $inspection->code }}</h5>
                            <div class="d-flex justify-content-center">
                                @can(['Checker'])
                                    @if($inspection->status == "DRAFT")
                                        <form id="posted-form" action="{{ route('console.inspection.posted', $inspection) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">POST</button>
                                        </form>
                                    @endif    
                                @endcan
                                @can(['Supervisor'])
                                    @if($inspection->status == "POSTED")
                                        <form id="approved-form" action="{{route('console.inspection.approve', $inspection->id)}}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-info mx-1"
                                            >Approve</button>
                                        </form>
                                        
                                        <form id="approved-form" action="{{route('console.inspection.reject', $inspection->id)}}" method="post">
                                            @csrf
                                            <button type="submit" onclick="return confirm('Yakin mau menolak inspeksi ini?')" class="btn  btn-danger">Reject</button>
                                        </form>
                                    @endif
                                @endcan
                                
                            </div>
                        </div>
                        <div class="card-body row">
                            <div class="col-lg-6">
                                <div class="form-group m-0 p-0 py-1">
                                    <label class="font-weight-bold m-0 p-0">Nomor Transaksi</label>
                                    <input class="form-control-plaintext p-0 m-0" value="{{ $inspection->code }}" />
                                </div>
                                <div class="form-group m-0 p-0 py-1">
                                    <label class="font-weight-bold m-0 p-0">Lokasi</label>
                                    <input class="form-control-plaintext p-0 " value="{{ $inspection->location->code }}" />
                                </div>
                                <div class="form-group m-0 p-0 py-1">
                                    <label class="font-weight-bold m-0 p-0 ">Tanggal & Waktu</label>
                                    <input class="form-control-plaintext m-0 p-0" value="{{ $inspection->action_date->format('d-m-Y H:i:s') }}" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-0 p-0 py-1">
                                    <label class="font-weight-bold m-0 p-0">No. KA</label>
                                    <input class="form-control-plaintext m-0 p-0" value="{{ $inspection->ka_no }}" />
                                </div>
                                <div class="form-group m-0 p-0 py-1">
                                    <label class="font-weight-bold m-0 p-0">Status</label>
                                    <input class="form-control-plaintext m-0 p-0" value="{{ $inspection->status }}" />
                                </div>
                                @can(['Supervisor', 'Administrator'])
                                    <livewire:inspection.form-header inspectionId="{{ $inspection->id }}" />
                                @endcan
                            </div>
                          
                        </div>
                    </div>

                    <div class="card mt-2">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5>Detail Inspeksi</h5>
                            @can(['Checker'])
                                @if($inspection->status == "DRAFT")
                                    <button class="btn btn-info" data-toggle="modal" data-target="#addDetailModal" ><i class="material-icons">add</i></button>
                                @endif
                            @endcan
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <livewire:inspection.table-inspection-detail inspectionId="{{ $inspection->id }}" />
                                {{-- <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Kontainer</th>
                                            <th>Detail kerusakan</th>
                                            <th>Penyebab Kerusakan</th>
                                            <th>Root Cause</th>
                                            <th>Tgl ditambah</th>
                                            <th>Gambar</th>
                                            <th>Garansi</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($inspection->details()->orderBy('container_code', 'asc')->get() as $key => $row)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $row->container_code }}</td>
                                                <td>{{ $row->damage_description }}</td>
                                                <td>{{ $row->damage_cause_description }}</td>
                                                <td>
                                                    @can(['Supervisor'])
                                                    <livewire:inspection.form-root-cause :rootCause="$rootCauseList" :detailsId="$row->id" :root_cause="$row->root_cause" />
                                                    @elsecan('Checker')
                                                        {{ $row->root_cause ?? '-' }}
                                                    @endcan
                                                </td>
                                                <td>{{ $row->created_at->format('d-m-Y H:i:s') }}</td>
                                                <td>
                                                    @foreach ($row->images as $img )
                                                        <a target="_blank" href="{{ Storage::url($img) }}">Tampilkan</a>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <livewire:container.warranty-modal ct="{{ $row->container_code }}"/>
                                                </td>
                                                <td class="">
                                                    @can(['Checker'])
                                                        @if($inspection->status == "DRAFT")
                                                            
                                                            <form action="{{ route('console.inspection.detail.destroy', $row->id) }}" method="post" class="d-flex flex-row">
                                                                @csrf
                                                                @method('delete')

                                                                <livewire:inspection.form-edit-modal detailId="{{ $row->id }}" />

                                                                <button type="submit" class="btn btn-danger mx-1" onclick="return confirm('Yakin mau dihapus?')">Delete</button>
                                                            </form>
                                                        @endif
                                                    @endcan
                                                </td>
                                            </tr>
                                        @empty
                                            
                                        @endforelse
                                    </tbody>
                                </table> --}}
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