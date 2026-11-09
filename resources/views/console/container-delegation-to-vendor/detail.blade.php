@extends('layouts.console')

@section('title')
    Detail BAST ke Vendor
@endsection

@section('nav')
    <ol class="breadcrumb my-0 ms-2">
        <li class="breadcrumb-item">
            <a href="{{ route('console.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('console.delegation-to-vendor.index') }}">Berita Serah Terima CT ke Vendor</a>
        </li>
        <li class="breadcrumb-item active"><span>Detail BAST CT Ke Vendor</span></li>
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
            {{-- @if ($containerDelegation->status == 'APPROVE3')
                <div class="row justify-content-center">
                    <div class="col-sm-12 px-4">
                        <div class="alert alert-success" role="alert">
                            BAST ({{ $containerDelegation->code }}) sudah APPROVE oleh <b>Finance Director</b> dan statusnya menjadi <b>APPROVE3</b>
                        </div>
                    </div>
                </div>
            @endif

            @can(['Checker'])    
                <div class="row justify-content-center">
                    <div class="col-sm-12 px-4">
                        @if ($containerDelegation->status == 'POSTED')
                            <div class="alert alert-warning" role="alert">
                                Status BAST ({{ $containerDelegation->code }}) sudah <b>POSTED</b> dan sedang dalam Review <b>CTC Supervisor</b>
                            </div>
                        @elseif ($containerDelegation->status == 'APPROVE1')
                            <div class="alert alert-success" role="alert">
                                BAST ({{ $containerDelegation->code }}) sudah APPROVE oleh <b>CTC Supervisor</b> dan statusnya menjadi <b>APPROVE1</b>
                            </div>
                        @endif
                    </div>
                </div>
            @endcan

            @can(['Supervisor'])    
                <div class="row justify-content-center">
                    <div class="col-sm-12 px-4">
                        @if ($containerDelegation->status == 'APPROVE1')
                            <div class="alert alert-warning" role="alert">
                                Status BAST ({{ $containerDelegation->code }}) sudah <b>APPROVE1</b> dan sedang dalam Review <b>CTC Manager</b>
                            </div>
                        @elseif ($containerDelegation->status == 'APPROVE2')
                            <div class="alert alert-success" role="alert">
                                BAST ({{ $containerDelegation->code }}) sudah APPROVE oleh <b>CTC Manager</b> dan statusnya menjadi <b>APPROVE2</b>
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12 px-4">
                        @if (($containerDelegation->reason_approve && $containerDelegation->status == 'APPROVE2') || $containerDelegation->status == 'APPROVE3')
                            <div class="alert alert-warning">
                               <b>Alasan Approve: </b> {{ $containerDelegation->reason_approve }}
                            </div>
                        @endif

                        @if ($containerDelegation->reason_reject && $containerDelegation->status == 'POSTED')
                            <div class="alert alert-warning">
                                <b>Alasan Reject: </b> {{ $containerDelegation->reason_reject }}
                            </div>
                        @endif
                    </div>
                </div>
            @endcan --}}

            <div class="col-sm-12">
                <div class="row mb-2">
                    <div class="col-sm-3">
                        <a href="{{ route('console.delegation-to-vendor.index') }}" class="btn-success btn btn-xs">
                            <i class="fas fa-arrow-left"></i>
                            back
                        </a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Berita Acara Serah Terima {{ $containerDelegation->code }}</h5>
                        <div>
                            @can(['Checker'])
                                @if ($containerDelegation->status == 'DRAFT')
                                    <form action="{{ route('console.delegation-to-vendor.posted', $containerDelegation) }}"
                                        method="post" onsubmit="return confirm('Apakah Anda Yakin ingin meng POST BAST ini?')">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">POST</button>
                                    </form>
                                @endif
                            @endcan

                            @can(['Supervisor'])
                                @if ($containerDelegation->status == 'POSTED')
                                    <div class="d-flex">
                                        <button class="btn btn-success mr-2" data-toggle="modal" data-target="#approveModal">
                                            <i class="fas fa-check"></i> Approve
                                        </button>
                                        <button class="btn btn-danger" data-toggle="modal" data-target="#rejectModal">
                                            <i class="fas fa-times"></i> Reject
                                        </button>

                                        <!-- Modal Approve -->
                                        <div class="modal fade" id="approveModal" tabindex="-1" role="dialog"
                                            aria-labelledby="approveModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form
                                                        action="{{ route('console.delegation-to-vendor.approve', $containerDelegation) }}"
                                                        method="post"
                                                        onsubmit="return confirm('Apakah Anda Yakin ingin meng Approve BAST ini?')">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Approve BAST</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="reason_approve">Alasan Approve
                                                                    <small>(Opsional)</small></label>
                                                                <textarea name="reason_approve" id="reason_approve" class="form-control" placeholder="Input Alasan"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-success">Approve</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Ebd Modal Approve -->

                                        <!-- Modal Reject -->
                                        <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog"
                                            aria-labelledby="rejectModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form
                                                        action="{{ route('console.delegation-to-vendor.reject', $containerDelegation) }}"
                                                        method="post"
                                                        onsubmit="return confirm('Apakah Anda Yakin ingin meng Reject BAST ini?')">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Reject BAST</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="reason_reject">Alasan Reject
                                                                    <small>(Opsional)</small></label>
                                                                <textarea name="reason_reject" id="reason_reject" class="form-control" placeholder="Input Alasan"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-danger">Reject</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endcan

                            @can(['Supervisor'])
                                @if ($containerDelegation->status != 'DRAFT' && $containerDelegation->status != 'POSTED')
                                    <div class="d-flex mb-2">
                                        <button class="btn btn-warning mr-2" data-toggle="modal" data-target="#cancelModal">
                                            <i class="fas fa-unlock"></i> Unapprove
                                        </button>
                                        <!-- Modal Unapprove -->
                                        <div class="modal fade" id="cancelModal" tabindex="-1" role="dialog"
                                            aria-labelledby="cancelModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form
                                                        action="{{ route('console.delegation-to-vendor.unapprove', $containerDelegation) }}"
                                                        method="post"
                                                        onsubmit="return confirm('Apakah Anda Yakin ingin merevisi BAST ini? \n Notifikasi akan dikirimkan ke CTC Manager.')">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Unapprove BAST</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="reason_reject">Alasan Unapprove</label>
                                                                <textarea name="reason_reject" id="reason_reject" class="form-control" placeholder="Input Alasan"></textarea>
                                                                <p><small style="color:red">*Pastikan detail container belum
                                                                        dilakukan BAST2.</small></p>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-danger">Unapprove</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endcan

                            @can(['Manager'])
                                @if ($containerDelegation->status == 'APPROVE1')
                                    <div class="d-flex">
                                        <button class="btn btn-success mr-2" data-toggle="modal" data-target="#approveModal">
                                            <i class="fas fa-check"></i> Approve
                                        </button>
                                        <button class="btn btn-danger" data-toggle="modal" data-target="#rejectModal">
                                            <i class="fas fa-times"></i> Reject
                                        </button>

                                        <!-- Modal Approve -->
                                        <div class="modal fade" id="approveModal" tabindex="-1" role="dialog"
                                            aria-labelledby="approveModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form
                                                        action="{{ route('console.delegation-to-vendor.approve', $containerDelegation) }}"
                                                        method="post"
                                                        onsubmit="return confirm('Apakah Anda Yakin ingin meng Approve BAST ini?')">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Approve BAST</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="reason_approve">Alasan Approve
                                                                    <small>(Opsional)</small></label>
                                                                <textarea name="reason_approve" id="reason_approve" class="form-control" placeholder="Input Alasan"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-success">Approve</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Ebd Modal Approve -->

                                        <!-- Modal Reject -->
                                        <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog"
                                            aria-labelledby="rejectModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form
                                                        action="{{ route('console.delegation-to-vendor.reject', $containerDelegation) }}"
                                                        method="post"
                                                        onsubmit="return confirm('Apakah Anda Yakin ingin meng Reject BAST ini?')">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Reject BAST</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="reason_reject">Alasan Reject
                                                                    <small>(Opsional)</small></label>
                                                                <textarea name="reason_reject" id="reason_reject" class="form-control" placeholder="Input Alasan"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-danger">Reject</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endcan

                            @can(['Finance'])
                                @if ($containerDelegation->status == 'APPROVE2')
                                    <div class="d-flex">
                                        <button class="btn btn-success mr-2" data-toggle="modal" data-target="#approveModal">
                                            <i class="fas fa-check"></i> Approve
                                        </button>
                                        <button class="btn btn-danger" data-toggle="modal" data-target="#rejectModal">
                                            <i class="fas fa-times"></i> Reject
                                        </button>

                                        <!-- Modal Approve -->
                                        <div class="modal fade" id="approveModal" tabindex="-1" role="dialog"
                                            aria-labelledby="approveModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form
                                                        action="{{ route('console.delegation-to-vendor.approve', $containerDelegation) }}"
                                                        method="post"
                                                        onsubmit="return confirm('Apakah Anda Yakin ingin meng Approve BAST ini?')">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Approve BAST</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="reason_approve">Alasan Approve
                                                                    <small>(Opsional)</small></label>
                                                                <textarea name="reason_approve" id="reason_approve" class="form-control" placeholder="Input Alasan"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-success">Approve</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Ebd Modal Approve -->

                                        <!-- Modal Reject -->
                                        <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog"
                                            aria-labelledby="rejectModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form
                                                        action="{{ route('console.delegation-to-vendor.reject', $containerDelegation) }}"
                                                        method="post"
                                                        onsubmit="return confirm('Apakah Anda Yakin ingin meng Reject BAST ini?')">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Reject BAST</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="reason_reject">Alasan Reject
                                                                    <small>(Opsional)</small></label>
                                                                <textarea name="reason_reject" id="reason_reject" class="form-control" placeholder="Input Alasan"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-danger">Reject</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endcan
                        </div>
                    </div>
                    <div class="card-body row">
                        <div class="col-lg-6">
                            <div class="form-group m-0 px-0 py-1">
                                <label class="font-weight-bold m-0 p-0">Nomor Transaksi</label>
                                <input class="form-control-plaintext m-0 p-0" value="{{ $containerDelegation->code }}" />
                            </div>
                            <div class="form-group m-0 px-0 py-1">
                                <label class="font-weight-bold m-0 p-0">Lokasi</label>
                                <input class="form-control-plaintext m-0 p-0"
                                    value="{{ $containerDelegation->location->code . ' (' . $containerDelegation->location->name . ')' }} " />
                            </div>
                            <div class="form-group m-0 px-0 py-1">
                                <label class="font-weight-bold m-0 p-0">Tanggal & Waktu</label>
                                <input class="form-control-plaintext m-0 p-0"
                                    value="{{ Carbon\Carbon::parse($containerDelegation->action_date)->format('d-m-Y H:i:s') }}" />
                            </div>
                            <div class="form-group m-0 px-0 py-1">
                                <label class="font-weight-bold m-0 p-0">Vendor</label>
                                <input class="form-control-plaintext m-0 p-0"
                                    value="{{ $containerDelegation->contract->vendor->name }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group m-0 px-0 py-1">
                                <label class="font-weight-bold m-0 p-0">Kontrak</label>
                                <input class="form-control-plaintext m-0 p-0"
                                    value="{{ $containerDelegation->contract->code }}">
                            </div>
                            <div class="form-group m-0 px-0 py-1">
                                <label class="font-weight-bold m-0 p-0">Tipe Transaksi</label>
                                <input class="form-control-plaintext m-0 p-0"
                                    value="{{ $containerDelegation->job_type }}">
                            </div>
                            <div class="form-group m-0 px-0 py-1">
                                <label class="font-weight-bold m-0 p-0">Status</label>
                                <input class="form-control-plaintext m-0 p-0"
                                    value="{{ $containerDelegation->status }}" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-2">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Detail BAST ke Vendor</h5>
                        @can('Administrator')
                            <button class="btn btn-info" data-toggle="modal" data-target="#delegationModal"><i
                                    class="material-icons">add</i></button>
                        @elsecan(['Checker'])
                            @if ($containerDelegation->status == 'DRAFT')
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
                                        <th>No</th>
                                        <th>Kode Kontainer</th>
                                        <th>Detail</th>
                                        <th>Deskripsi</th>
                                        <th>Gambar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($containerDelegation->details()->orderBy('container_code', 'asc')->get() as $key => $row)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $row->container_code }}</td>
                                            <td>
                                                @can(['Checker', 'Supervisor', 'Manager', 'Finance', 'Site Manager'])
                                                    <a href="{{ route('console.delegation-to-vendor.sub-detail.index', [$containerDelegation->id, $row->id]) }}"
                                                        class=" btn btn-info btn-sm">
                                                        <i class="fa fa-eye"></i> Detail Kerusakan
                                                    </a>
                                                @endcan
                                            </td>
                                            <td>{{ $row->container_damage }}</td>
                                            <td>
                                                @foreach ($row->images as $img)
                                                    <a href="{{ Storage::url($img) }}" target="_blank"
                                                        class="d-block">Tampilkan</a>
                                                @endforeach
                                            </td>
                                            <td>
                                                @can(['Checker'])
                                                    @if ($containerDelegation->status == 'DRAFT')
                                                        <form
                                                            action="{{ route('console.delegation-to-vendor.detail.delete', [$containerDelegation->id, $row->id]) }}"
                                                            onsubmit="return confirm('Apakah Anda Yakin?')" method="POST">
                                                            @csrf
                                                            @method('DELETE')

                                                            <button class="btn btn-sm btn-danger">Hapus</button>
                                                        </form>
                                                    @endif
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
    </section>

    {{-- Start Modal --}}
    <!-- Modal -->
    <div class="modal fade" id="delegationModal" tabindex="-1" role="dialog" aria-labelledby="delegationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <livewire:container-delegation-to-vendor.form-detail containerDelegationId="{{ $containerDelegation->id }}" />
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
