@extends('layouts.console')

@section('title')
    Detail Proses Scrap CT
@endsection

@section('nav')
    <ol class="breadcrumb my-0 ms-2">
        <li class="breadcrumb-item">
            <a href="{{ route('console.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('console.container-scrap.index') }}">Proses Scrap CT</a>
        </li>
        <li class="breadcrumb-item active"><span>Detail Proses Scrap CT</span></li>
    </ol>
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="row my-3">
                <div class="col-sm-12 px-4">
                    @include('partials.alert')
                </div>
            </div>
        </div>
        <div class="section-body pb-5">
            {{-- @can(['Checker'])    
                <div class="row justify-content-center">
                    <div class="col-sm-12 px-4">
                        @if ($containerScrap->status == 'POSTED')
                            <div class="alert alert-warning" role="alert">
                                Status BAST ({{ $containerScrap->code }}) sudah <b>POSTED</b> dan sedang dalam Review <b>CTC Supervisor</b>
                            </div>
                        @endif
                    </div>
                </div>
            @endcan

            @if ($containerScrap->status == 'APPROVE')
                <div class="row justify-content-center">
                    <div class="col-sm-12 px-4">
                        <div class="alert alert-success" role="alert">
                            BAST ({{ $containerScrap->code }}) sudah APPROVE oleh <b>CTC Supervisor</b> dan statusnya menjadi <b>APPROVE</b>
                        </div>
                    </div>
                </div>
            @endif --}}

            <div class="col-sm-12">
                <div class="row mb-2">
                    <div class="col-sm-3">
                        <a href="{{ route('console.container-scrap.index') }}" class="btn-success btn btn-xs">
                            <i class="fas fa-arrow-left"></i>
                            back
                        </a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5><strong>Proses Scrap Container {{ $containerScrap->code }}</strong></h5>
                        <div>
                            @can(['Supervisor'])
                                @if ($containerScrap->status == 'DRAFT')
                                    <form action="{{ route('console.container-scrap.posted', $containerScrap) }}" method="post"
                                        id="posted-form">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">POST</button>
                                    </form>
                                @endif
                            @endcan

                            @can(['Manager'])
                                @if ($containerScrap->status == 'POSTED')
                                    <div class="d-flex">
                                        <!-- Approve -->
                                        <form action="{{ route('console.container-scrap.approve', $containerScrap) }}"
                                            method="post"
                                            onsubmit="return confirm('Apakah Anda Yakin ingin menyetujui Proses Scrap ini?')">
                                            @csrf
                                            @method('PUT')

                                            <button type="submit" class="btn btn-success mr-2">Approve</button>
                                        </form>

                                        <!-- Reject -->
                                        <form action="{{ route('console.container-scrap.reject', $containerScrap) }}"
                                            method="post"
                                            onsubmit="return confirm('Apakah Anda Yakin ingin menolak Proses Scrap ini?')">
                                            @csrf
                                            @method('PUT')

                                            <button type="submit" class="btn btn-danger">Reject</button>
                                        </form>
                                    </div>
                                @endif
                            @endcan
                        </div>
                    </div>
                    <div class="card-body row">
                        <div class="col-lg-6">
                            <div class="form-group m-0 px-0 py-1">
                                <label class="font-weight-bold m-0 p-0">Nomor Transaksi</label>
                                <input class="form-control-plaintext m-0 p-0" value="{{ $containerScrap->code }}" />
                            </div>
                            <div class="form-group m-0 px-0 py-1">
                                <label class="font-weight-bold m-0 p-0">Lokasi</label>
                                <input class="form-control-plaintext m-0 p-0"
                                    value="{{ $containerScrap->location->code . ' (' . $containerScrap->location->name . ')' }} " />
                            </div>
                            <div class="form-group m-0 px-0 py-1">
                                <label class="font-weight-bold m-0 p-0">Tanggal & Waktu</label>
                                <input class="form-control-plaintext m-0 p-0"
                                    value="{{ Carbon\Carbon::parse($containerScrap->action_date)->format('d-m-Y H:i:s') }}" />
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group m-0 px-0 py-1">
                                <label class="font-weight-bold m-0 p-0">Vendor</label>
                                <input class="form-control-plaintext m-0 p-0" value="{{ $containerScrap->vendor->name }}">
                            </div>
                            <div class="form-group m-0 px-0 py-1">
                                <label class="font-weight-bold m-0 p-0">Documents</label><br>
                                <td>
                                    @foreach ($containerScrap->documents as $img)
                                        <a style="color :green" href="{{ Storage::url($img) }}" target="_blank">Document
                                            {{ $loop->index + 1 }}</a>
                                    @endforeach
                                </td>
                            </div>
                            <div class="form-group m-0 px-0 py-1">
                                <label class="font-weight-bold m-0 p-0">Status</label>
                                <input class="form-control-plaintext m-0 p-0" value="{{ $containerScrap->status }}" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-2">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5><strong>Detail Scrap CT</strong></h5>
                        @can(['Supervisor'])
                            @if ($containerScrap->status == 'DRAFT')
                                <button class="btn btn-info" data-toggle="modal" data-target="#containerScrapModal"><i
                                        class="material-icons">add</i></button>
                            @endif
                        @endcan
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <livewire:container-scrap.table-scrap-detail containerScrapId="{{ $containerScrap->id }}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Start Modal --}}
    <div class="modal fade" id="containerScrapModal" tabindex="-1" role="dialog" aria-labelledby="delegationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <livewire:container-scrap.form-detail :containerScrap="$containerScrap" />
        </div>
    </div>
    {{-- End Modal --}}
@endsection

@push('scripts')
    <script>
        $(function() {
            $('#posted-form').on('submit', function(e) {

                if (confirm('Apakah anda yakin?')) {

                } else {
                    e.preventDefault();
                }
            });
        });
    </script>
@endpush
