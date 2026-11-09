@extends('layouts.console')

@section('title')
    Sub Detail BAST ke Vendor
@endsection

@section('nav')
    <ol class="breadcrumb my-0 ms-2">
        <li class="breadcrumb-item">
            <a href="{{ route('console.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('console.delegation-to-vendor.index') }}">Berita Serah Terima CT ke Vendor</a>
        </li>
        <li class="breadcrumb-item">
            <a
                href="{{ route('console.delegation-to-vendor.detail', $containerDelegationDetail->containerDelegation->id) }}">Detail
                BAST CT Ke Vendor</a>
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
                    <a href="{{ route('console.delegation-to-vendor.detail', $containerDelegationDetail->containerDelegation->id) }}"
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
                                {{ $containerDelegationDetail->containerDelegation->code }}</h5>
                        </div>
                        <div class="card-body row">
                            <div class="col-lg-6">
                                <div class="form-group m-0 px-0 py-1">
                                    <label class="font-weight-bold m-0 p-0">Nomor Transaksi</label>
                                    <input class="form-control-plaintext m-0 p-0"
                                        value="{{ $containerDelegationDetail->containerDelegation->code }}" />
                                </div>
                                <div class="form-group m-0 px-0 py-1">
                                    <label class="font-weight-bold m-0 p-0">Lokasi</label>
                                    <input class="form-control-plaintext m-0 p-0"
                                        value="{{ $containerDelegationDetail->containerDelegation->location->code . ' (' . $containerDelegationDetail->containerDelegation->location->name . ')' }} " />
                                </div>
                                <div class="form-group m-0 px-0 py-1">
                                    <label class="font-weight-bold m-0 p-0">Tanggal & Waktu</label>
                                    <input class="form-control-plaintext m-0 p-0"
                                        value="{{ Carbon\Carbon::parse($containerDelegationDetail->containerDelegation->action_date)->format('d-m-Y H:i:s') }}" />
                                </div>
                                <div class="form-group m-0 px-0 py-1">
                                    <label class="font-weight-bold m-0 p-0">Vendor</label>
                                    <input class="form-control-plaintext m-0 p-0"
                                        value="{{ $containerDelegationDetail->containerDelegation->contract->vendor->name }}">
                                </div>
                                <div class="form-group m-0 px-0 py-1">
                                    <label class="font-weight-bold m-0 p-0">Kontrak</label>
                                    <input class="form-control-plaintext m-0 p-0"
                                        value="{{ $containerDelegationDetail->containerDelegation->contract->code }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-0 px-0 py-1">
                                    <label class="font-weight-bold m-0 p-0">Tipe Transaksi</label>
                                    <input class="form-control-plaintext m-0 p-0"
                                        value="{{ $containerDelegationDetail->containerDelegation->job_type }}">
                                </div>
                                <div class="form-group m-0 px-0 py-1">
                                    <label class="font-weight-bold m-0 p-0">Status</label>
                                    <input class="form-control-plaintext m-0 p-0"
                                        value="{{ $containerDelegationDetail->containerDelegation->status }}" />
                                </div>
                                <div class="form-group m-0 px-0 py-1">
                                    <label class="font-weight-bold m-0 p-0">Kode Kontainer</label>
                                    <input class="form-control-plaintext m-0 p-0"
                                        value="{{ $containerDelegationDetail->container_code }}" />
                                </div>
                                <div class="form-group m-0 px-0 py-1">
                                    <label class="font-weight-bold m-0 p-0">Deskripsi</label>
                                    <input class="form-control-plaintext m-0 p-0"
                                        value="{{ $containerDelegationDetail->container_damage }}" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-2">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5>Sub Detail BAST ke Vendor</h5>
                            @can(['Checker'])
                                @if ($containerDelegationDetail->containerDelegation->status == 'DRAFT')
                                    <button class="btn btn-info" data-toggle="modal" data-target="#delegationDetailModal"><i
                                            class="material-icons">add</i></button>
                                @endif
                            @endcan
                            @can(['Administrator'])
                                @if ($containerDelegationDetail->containerDelegation->status != 'DRAFT')
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
                                            <th>Gambar</th>
                                            @can(['Checker'])
                                                @if ($containerDelegationDetail->containerDelegation->status == 'DRAFT')
                                                    <th>Aksi</th>
                                                @endif
                                            @endcan
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($containerDelegationDetail->subDetails()->orderBy('id', 'asc')->get() as $key => $row)
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
                                                        <a href="{{ Storage::url($img) }}" target="_blank">Tampilkan</a>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @if ($containerDelegationDetail->containerDelegation->status == 'DRAFT')
                                                        <div class="d-flex justify-content-between">
                                                            @can(['Checker'])
                                                                <form
                                                                    action="{{ route('console.delegation-to-vendor.sub-detail.duplicate', [$containerDelegationDetail->containerDelegation->id, $containerDelegationDetail->id, $row->id]) }}"
                                                                    method="POST">
                                                                    @csrf

                                                                    <button type="submit"
                                                                        class="btn btn-sm btn-success mr-2">Duplicate</button>
                                                                </form>

                                                                <livewire:container-delegation-to-vendor.form-edit-sub-detail
                                                                    :delegationDetailId="$containerDelegationDetail->id" :subDetailId="$row->id">
                                                                @endcan

                                                                @can(['Checker'])
                                                                    <form
                                                                        action="{{ route('console.delegation-to-vendor.sub-detail.destroy', [$containerDelegationDetail->containerDelegation->id, $containerDelegationDetail->id, $row->id]) }}"
                                                                        method="POST"
                                                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                                        @csrf
                                                                        @method('DELETE')

                                                                        <button class="btn btn-sm btn-danger ml-2"
                                                                            type="submit">Hapus</button>
                                                                    </form>
                                                                @endcan
                                                        </div>
                                                    @elseif ($containerDelegationDetail->containerDelegation->status == 'POSTED')
                                                        @can(['Supervisor'])
                                                            <livewire:container-delegation-to-vendor.form-edit-sub-detail
                                                                :delegationDetailId="$containerDelegationDetail->id" :subDetailId="$row->id">
                                                            @endcan
                                                        @elseif (
                                                            $containerDelegationDetail->containerDelegation->status == 'APPROVE2' ||
                                                                $containerDelegationDetail->containerDelegation->status == 'APPROVE1')
                                                            <div class="d-flex justify-content-between">
                                                                @can(['Administrator'])
                                                                    <form
                                                                        action="{{ route('console.delegation-to-vendor.sub-detail.duplicate', [$containerDelegationDetail->containerDelegation->id, $containerDelegationDetail->id, $row->id]) }}"
                                                                        method="POST">
                                                                        @csrf

                                                                        <button type="submit"
                                                                            class="btn btn-sm btn-success mr-2">Duplicate</button>
                                                                    </form>

                                                                    <livewire:container-delegation-to-vendor.form-edit-sub-detail
                                                                        :delegationDetailId="$containerDelegationDetail->id" :subDetailId="$row->id">
                                                                    @endcan

                                                                    @can(['Administrator'])
                                                                        <form
                                                                            action="{{ route('console.delegation-to-vendor.sub-detail.destroy', [$containerDelegationDetail->containerDelegation->id, $containerDelegationDetail->id, $row->id]) }}"
                                                                            method="POST"
                                                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                                            @csrf
                                                                            @method('DELETE')

                                                                            <button class="btn btn-sm btn-danger ml-2"
                                                                                type="submit">Hapus</button>
                                                                        </form>
                                                                    @endcan
                                                            </div>
                                                    @endif
                                                </td>
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
    <!-- Modal -->
    <div class="modal fade" id="delegationDetailModal">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <livewire:container-delegation-to-vendor.form-sub-detail
                containerDelegationDetailId="{{ $containerDelegationDetail->id }}" />
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
