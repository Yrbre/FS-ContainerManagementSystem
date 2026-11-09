@extends('layouts.console')

@section('title')
    Sub Detail BAST dari Vendor
@endsection

@section('nav')
    <ol class="breadcrumb my-0 ms-2">
        <li class="breadcrumb-item">
            <a href="{{ route('console.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('console.delegation-from-vendor.index') }}">Berita Serah Terima CT dari Vendor</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('console.delegation-from-vendor.detail', $ctFromVendorDetail->delegationFromVendor->id) }}">Detail
                BAST CT Dari Vendor</a>
        </li>
        <li class="breadcrumb-item active"><span>Sub Detail</span></li>
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
            <div class="row mb-2">
                <div class="col-sm-3">
                    <a href="{{ route('console.delegation-from-vendor.detail', $ctFromVendorDetail->delegationFromVendor->id) }}"
                        class="btn-success btn btn-xs">
                        <i class="fas fa-arrow-left"></i>
                        back
                    </a>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h5 class="mb-0">Berita Acara Serah Terima
                                {{ $ctFromVendorDetail->delegationFromVendor->code }}</h5>
                        </div>
                        <div class="card-body row">
                            <div class="col-lg-6">
                                <div class="form-group m-0 px-0 py-1">
                                    <label class="font-weight-bold m-0 p-0">Nomor Transaksi</label>
                                    <input class="form-control-plaintext m-0 p-0"
                                        value="{{ $ctFromVendorDetail->delegationFromVendor->code }}" />
                                </div>
                                <div class="form-group m-0 px-0 py-1">
                                    <label class="font-weight-bold m-0 p-0">Lokasi</label>
                                    <input class="form-control-plaintext m-0 p-0"
                                        value="{{ $ctFromVendorDetail->delegationFromVendor->location->code . ' (' . $ctFromVendorDetail->delegationFromVendor->location->name . ')' }} " />
                                </div>
                                <div class="form-group m-0 px-0 py-1">
                                    <label class="font-weight-bold m-0 p-0">Tanggal & Waktu</label>
                                    <input class="form-control-plaintext m-0 p-0"
                                        value="{{ Carbon\Carbon::parse($ctFromVendorDetail->delegationFromVendor->action_date)->format('d-m-Y H:i:s') }}" />
                                </div>
                                <div class="form-group m-0 px-0 py-1">
                                    <label class="font-weight-bold m-0 p-0">Vendor</label>
                                    <input class="form-control-plaintext m-0 p-0"
                                        value="{{ $ctFromVendorDetail->delegationFromVendor->vendor->name }}">
                                </div>
                                {{-- <div class="form-group m-0 px-0 py-1">
                                    <label class="font-weight-bold m-0 p-0">Kontrak</label>
                                    <input class="form-control-plaintext m-0 p-0" value="{{ $ctFromVendorDetail->delegationFromVendor->code }}">
                                </div> --}}
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-0 px-0 py-1">
                                    <label class="font-weight-bold m-0 p-0">Tipe Transaksi</label>
                                    <input class="form-control-plaintext m-0 p-0"
                                        value="{{ $ctFromVendorDetail->delegationFromVendor->job_type }}">
                                </div>
                                <div class="form-group m-0 px-0 py-1">
                                    <label class="font-weight-bold m-0 p-0">Status</label>
                                    <input class="form-control-plaintext m-0 p-0"
                                        value="{{ $ctFromVendorDetail->delegationFromVendor->status }}" />
                                </div>
                                <div class="form-group m-0 px-0 py-1">
                                    <label class="font-weight-bold m-0 p-0">Kode Kontainer</label>
                                    <input class="form-control-plaintext m-0 p-0"
                                        value="{{ $ctFromVendorDetail->container_code }}" />
                                </div>
                                <div class="form-group m-0 px-0 py-1">
                                    <label class="font-weight-bold m-0 p-0">Deskripsi</label>
                                    <input class="form-control-plaintext m-0 p-0"
                                        value="{{ $ctFromVendorDetail->container_damage }}" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-2">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5>Sub Detail BAST dari Vendor</h5>
                            @can(['Checker'])
                                @if ($ctFromVendorDetail->delegationFromVendor->status == 'DRAFT')
                                    @if ($ctFromVendorDetail->delegationFromVendor->job_type == 'Upgrade & Repair')
                                        <button class="btn btn-info" data-toggle="modal" data-target="#delegationDetailModal"><i
                                                class="material-icons">add</i></button>
                                    @endif
                                @endif
                            @endcan
                            @can(['Administrator'])
                                @if ($ctFromVendorDetail->delegationFromVendor->job_type == 'Upgrade & Repair')
                                    <button class="btn btn-info" data-toggle="modal" data-target="#delegationDetailModal"><i
                                            class="material-icons">add</i></button>
                                @endif
                            @endcan
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Detail Kerusakan</th>
                                            <th>Root Cause</th>
                                            <th>Jenis perbaikan</th>
                                            <th>Keterangan</th>
                                            <th>Ukuran Material</th>
                                            <th>Satuan</th>
                                            <th>Kuantitas</th>
                                            <th>Harga Satuan</th>
                                            <th>Estimasi Harga</th>
                                            <th>Gambar Sebelum</th>
                                            <th>Gambar Sesudah</th>
                                            @can(['Checker'])
                                                @if ($ctFromVendorDetail->delegationFromVendor->status == 'DRAFT')
                                                    <th>Aksi</th>
                                                @endif
                                            @endcan
                                            @can(['Supervisor'])
                                                @if ($ctFromVendorDetail->delegationFromVendor->status == 'POSTED')
                                                    <th>Aksi</th>
                                                @endif
                                            @endcan
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($ctFromVendorDetail->sub()->orderBy('id', 'asc')->get() as $key => $row)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $row->damage_description }}</td>
                                                <td>{{ $row->root_cause }}</td>
                                                <td>{{ $row->job_type }}</td>
                                                <td>{{ $row->description }}</td>
                                                <td>{{ $row->material_size }}</td>
                                                <td>{{ $row->unit }}</td>
                                                <td>{{ number_format($row->qty) }}</td>
                                                <td>{{ 'Rp. ' . number_format($row->unit_price) }}</td>
                                                <td>{{ 'Rp. ' . number_format($row->price_estimation) }}</td>
                                                <td>
                                                    @foreach ($row->images as $img)
                                                        <a href="{{ Storage::url($img) }}" target="_blank"
                                                            class="d-block">Tampilkan</a>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @if ($row->images_after)
                                                        @foreach ($row->images_after as $imgAfter)
                                                            <a href="{{ Storage::url($imgAfter) }}" target="_blank"
                                                                class="d-block">Tampilkan</a>
                                                        @endforeach
                                                    @endif
                                                </td>
                                                @can(['Checker'])
                                                    @if ($ctFromVendorDetail->delegationFromVendor->status == 'DRAFT')
                                                        <td>
                                                            <livewire:container-delegation-from-vendor.form-edit-image-sub-detail
                                                                ctFromVendorSubDetailId="{{ $row->id }}">
                                                        </td>
                                                    @endif
                                                @endcan

                                                @can(['Supervisor'])
                                                    @if ($ctFromVendorDetail->delegationFromVendor->status == 'POSTED')
                                                        <td>
                                                            <livewire:container-delegation-from-vendor.form-edit-sub-detail
                                                                :delegationFromVendorDetailId="$ctFromVendorDetail->id" :subDetailId="$row->id">
                                                        </td>
                                                    @endif
                                                @endcan

                                                @can(['Administrator'])
                                                    <td>
                                                        <form
                                                            action="{{ route('console.delegation-from-vendor.sub-detail.duplicate', [$ctFromVendorDetail->delegationFromVendor->id, $ctFromVendorDetail->id, $row->id]) }}"
                                                            method="POST">
                                                            @csrf

                                                            <button type="submit"
                                                                class="btn btn-sm btn-success mr-2">Duplicate</button>
                                                        </form>
                                                        @if ($ctFromVendorDetail->delegationFromVendor->status != 'POSTED')
                                                            <livewire:container-delegation-from-vendor.form-edit-sub-detail
                                                                :delegationFromVendorDetailId="$ctFromVendorDetail->id" :subDetailId="$row->id">
                                                        @endif
                                                    </td>
                                                @endcan
                                            </tr>
                                        @empty
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Start Modal --}}
    <div class="modal fade" id="delegationDetailModal">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <livewire:container-delegation-from-vendor.form-sub-detail
                ctFromVendorDetailId="{{ $ctFromVendorDetail->id }}">
        </div>
    </div>
    {{-- End Modal --}}
@endsection
