@extends('layouts.console')

@section('title')
    Detail BAST Dari Vendor
@endsection

@section('nav')
    <ol class="breadcrumb my-0 ms-2">
        <li class="breadcrumb-item">
            <a href="{{ route('console.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('console.delegation-from-vendor.index') }}">Berita Serah Terima CT Dari Vendor</a>
        </li>
        <li class="breadcrumb-item active"><span>Detail BAST CT Dari Vendor</span></li>
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
                        @if ($containerDelegationFromVendor->status == 'POSTED')
                            <div class="alert alert-warning" role="alert">
                                Status BAST ({{ $containerDelegationFromVendor->code }}) sudah <b>POSTED</b> dan sedang dalam Review <b>CTC Supervisor</b>
                            </div>
                        @endif
                    </div>
                </div>
            @endcan

            @if ($containerDelegationFromVendor->status == 'APPROVE')
                <div class="row justify-content-center">
                    <div class="col-sm-12 px-4">
                        <div class="alert alert-success" role="alert">
                            BAST ({{ $containerDelegationFromVendor->code }}) sudah APPROVE oleh <b>CTC Supervisor</b> dan statusnya menjadi <b>APPROVE</b>
                        </div>
                    </div>
                </div>
            @endif --}}

            <div class="col-sm-12">
                <div class="row mb-2">
                    <div class="col-sm-3">
                        <a href="{{ route('console.delegation-from-vendor.index') }}" class="btn-success btn btn-xs">
                            <i class="fas fa-arrow-left"></i>
                            back
                        </a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Berita Acara Serah Terima {{ $containerDelegationFromVendor->code }}</h5>
                        <div>
                            @can(['Checker'])
                                @if ($containerDelegationFromVendor->status == 'DRAFT')
                                    <form
                                        action="{{ route('console.delegation-from-vendor.posted', $containerDelegationFromVendor) }}"
                                        method="post" id="posted-form">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">POST</button>
                                    </form>
                                @endif
                            @endcan

                            @can(['Supervisor'])
                                @if ($containerDelegationFromVendor->status == 'POSTED')
                                    <div class="d-flex">
                                        <!-- Approve -->
                                        <form
                                            action="{{ route('console.delegation-from-vendor.approve', $containerDelegationFromVendor) }}"
                                            method="post"
                                            onsubmit="return confirm('Apakah Anda Yakin ingin meng Approve BAST ini?')">
                                            @csrf
                                            @method('PUT')

                                            <button type="submit" class="btn btn-success mr-2">Approve</button>
                                        </form>

                                        <!-- Reject -->
                                        <form
                                            action="{{ route('console.delegation-from-vendor.reject', $containerDelegationFromVendor) }}"
                                            method="post"
                                            onsubmit="return confirm('Apakah Anda Yakin ingin meng Reject BAST ini?')">
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
                                <input class="form-control-plaintext m-0 p-0"
                                    value="{{ $containerDelegationFromVendor->code }}" />
                            </div>
                            <div class="form-group m-0 px-0 py-1">
                                <label class="font-weight-bold m-0 p-0">Lokasi</label>
                                <input class="form-control-plaintext m-0 p-0"
                                    value="{{ $containerDelegationFromVendor->location->code . ' (' . $containerDelegationFromVendor->location->name . ')' }} " />
                            </div>
                            <div class="form-group m-0 px-0 py-1">
                                <label class="font-weight-bold m-0 p-0">Tanggal & Waktu</label>
                                <input class="form-control-plaintext m-0 p-0"
                                    value="{{ Carbon\Carbon::parse($containerDelegationFromVendor->action_date)->format('d-m-Y H:i:s') }}" />
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group m-0 px-0 py-1">
                                <label class="font-weight-bold m-0 p-0">Vendor</label>
                                <input class="form-control-plaintext m-0 p-0"
                                    value="{{ $containerDelegationFromVendor->vendor->name }}">
                            </div>
                            <div class="form-group m-0 px-0 py-1">
                                <label class="font-weight-bold m-0 p-0">Tipe Transaksi</label>
                                <input class="form-control-plaintext m-0 p-0"
                                    value="{{ $containerDelegationFromVendor->job_type }}">
                            </div>
                            <div class="form-group m-0 px-0 py-1">
                                <label class="font-weight-bold m-0 p-0">Status</label>
                                <input class="form-control-plaintext m-0 p-0"
                                    value="{{ $containerDelegationFromVendor->status }}" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-2">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Detail BAST dari Vendor</h5>
                        @can('Administrator')
                            <button class="btn btn-info" data-toggle="modal" data-target="#delegationModal"><i
                                    class="material-icons">add</i></button>
                        @elsecan(['Checker'])
                            @if ($containerDelegationFromVendor->status == 'DRAFT')
                                <button class="btn btn-info" data-toggle="modal" data-target="#delegationModal"><i
                                        class="material-icons">add</i></button>
                            @endif
                        @endcan
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Kode Kontainer</th>
                                        <th>Detail</th>
                                        <th>Kerusakan Kontainer</th>
                                        <th>Tgl. Serah Terima ke Vendor</th>
                                        <th>Progres (%)</th>
                                        <th>Foto Setelah Perbaikan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($containerDelegationFromVendor->details()->orderBy('container_code', 'asc')->get() as $key => $row)
                                        <tr>
                                            <td>{{ $row->container_code }}</td>
                                            <td>
                                                @can(['Checker', 'Supervisor', 'Manager', 'Site Manager'])
                                                    <a href="{{ route('console.delegation-from-vendor.sub-detail.index', [$containerDelegationFromVendor->id, $row->id]) }}"
                                                        class=" btn btn-info btn-sm">
                                                        <i class="fa fa-eye"></i> Detail Kerusakan
                                                    </a>
                                                @endcan
                                            </td>
                                            <td>{{ $row->container_damage }}</td>
                                            <td>{{ DateHelper::format($row->delegation_to_vendor_date) ?? '-' }}</td>
                                            <td>{{ $row->progress }} %</td>
                                            <td>
                                                @foreach ($row->images as $img)
                                                    <a href="{{ Storage::url($img) }}" target="_blank">Tampilkan</a>
                                                @endforeach
                                            </td>
                                            <td>
                                                @can(['Checker', 'Administrator'])
                                                    <form
                                                        action="{{ route('console.delegation-from-vendor.detail.destroy', [$containerDelegationFromVendor, $row->id]) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        @if ($containerDelegationFromVendor->status == 'DRAFT')
                                                            <button class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Yakin mau dihapus?')">Delete</button>
                                                        @endif
                                                    </form>
                                                @endcan
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
    </section>

    {{-- Start Modal --}}
    <div class="modal fade" id="delegationModal" tabindex="-1" role="dialog" aria-labelledby="delegationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <livewire:container-delegation-from-vendor.form-detail :containerDelegationFromVendor="$containerDelegationFromVendor" />
        </div>
    </div>
    {{-- End Modal --}}
@endsection

@push('scripts')
    @php
        $details = $containerDelegationFromVendor->details()->get();
    @endphp

    @if ($details)
        @php
            $progress = 0;
        @endphp
        @foreach ($details as $detail)
            @php
                $progress = (int) $detail->progress;
            @endphp
        @endforeach

        @if ($progress != 100)
            <script>
                $(function() {
                    $('#posted-form').on('submit', function(e) {

                        if (confirm(
                                'Apakah Anda Yakin? Ada Container yang Progress nya belum 100%. Silahkan klik OK untuk melanjutkan.'
                                )) {

                        } else {
                            e.preventDefault();
                        }
                    });
                });
            </script>
        @else
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
        @endif
    @endif
@endpush
