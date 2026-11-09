@extends('layouts.console')

@section('title')
    Detail Kontainer
@endsection

@section('nav')
    <ol class="breadcrumb my-0 ms-2">
        <li class="breadcrumb-item">
            <a href="{{ route('console.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('console.container.index') }}">Kontainer</a>
        </li>
        <li class="breadcrumb-item active"><span>Detail Kontainer</span></li>
    </ol>
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="my-3">
                @include('partials.alert')
            </div>
        </div>
        <div class="section-body mb-5">
            <div class="row mb-2">
                <div class="col-sm-2">
                    <a href="{{ route('console.container.index') }}" class="btn-success btn btn-xs">
                        <i class="fas fa-arrow-left"></i>
                        back
                    </a>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Detail Kontainer</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Nomor CT</label>
                                        <input class="form-control" type="text" name="code" value="{{ $container->code }}" readonly />
                                    </div>
        
                                    <div class="form-group">
                                        <label>No Fixed Asset</label>
                                        <input class="form-control" type="text" name="fixed_asset_number" value="{{ $container->fixed_asset_number }}" readonly />
                                    </div>
        
                                    <div class="form-group">
                                        <label>Vendor Pembelian</label>
                                        <input type="text" name="vendor_id" class="form-control" value="{{ $container->vendor->name }}" readonly>
                                    </div>
        
                                    <div class="form-group">
                                        <label>Tanggal Pembelian</label>
                                        <input class="form-control" type="text" name="buy_date" value="@if($container->buy_date) {{ \Carbon\Carbon::parse($container->buy_date)->format('d-m-Y') }} @endif" readonly />
                                    </div>
        
                                    <div class="form-group">
                                        <label>Vendor Upgrade & Repair terkahir</label>
                                        <input type="text" class="form-control" value="{{ $container->lastUpgradeVendor->name }}" readonly>
                                    </div>
        
                                    <div class="form-group">
                                        <label>Tanggal Upgrade & Repair Terakhir</label>
                                        <input class="form-control " type="datetime"
                                            name="last_upgrade_date" value="@if($container->last_upgrade_date) {{ \Carbon\Carbon::parse($container->last_upgrade_date)->format('d-m-Y') }} @endif" readonly />
                                    </div>
        
                                    <div class="form-group">
                                        <label>Vendor Maintenance terkahir</label>
                                        <input type="text" class="form-control" value="{{ $container->lastMaintenanceVendor->name }}" readonly>
                                    </div>
        
                                    <div class="form-group">
                                        <label>Tanggal Maintenance Terakhir</label>
                                        <input class="form-control" type="datetime" name="last_maintenance_date" value="@if($container->last_maintenance_date) {{ \Carbon\Carbon::parse($container->last_maintenance_date)->format('d-m-Y') }} @endif"  readonly/>
                                    </div>
        
                                    <div class="form-group">
                                        <label>Nomor Kontrak</label>
                                        <input class="form-control" type="text" name="contract_id" value="@if(isset($container->contract)){{ $container->contract->code }}  @endif"  readonly />
                                    </div>
        
                                    <div class="form-group">
                                        <label>Perusahaan</label>
                                        <input class="form-control" name="company_id" value="{{ $container->company->name }}" readonly />
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Panjang</label>
                                                <div class="input-group">
                                                    <input class="form-control" type="text" name="length" value="{{ number_format($container->length) }}" readonly />
                                                    
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">cm</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Tinggi</label>
                                                <div class="input-group">
                                                    <input class="form-control" type="text" name="height" value="{{ number_format($container->height) }} m" readonly />

                                                    <div class="input-group-append">
                                                        <span class="input-group-text">cm</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Lebar</label>
                                                <div class="input-group">
                                                    <input class="form-control" type="text" name="width" value="{{ number_format($container->width) }} m" readonly />

                                                    <div class="input-group-append">
                                                        <span class="input-group-text">cm</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
        
                                    <div class="form-group">
                                        <label>Deskripsi</label>
                                        <textarea class="form-control" name="description" readonly >{{ $container->description }}</textarea>
                                    </div>
        
                                    <div class="form-group">
                                        <label>Daftar Dokumen</label>
                                        <div>
                                            <ol>
                                                @foreach ($documents as $document)
                                                    <li>
                                                        <a href="{{ Storage::url($document->document_location) }}" class="text-primary" target="_blank">{{ $document->file_name }}</a>
                                                    </li>
                                                @endforeach
                                            </ol>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <input type="text" class="form-control" name="container_status_id" value="{{ $container->status->description }}" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label>Tanggal Mulai Garansi</label>
                                        <input type="text" class="form-control" name="warranty_date_start" value="@if($container->contract){{  \Carbon\Carbon::parse($container->warranty_date_start)->format('d-m-Y') }} @endif" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label>Tanggal Selesai Garansi</label>
                                        <input type="text" class="form-control" name="warranty_date_end" value="@if($container->contract){{   \Carbon\Carbon::parse($container->warranty_date_end)->format('d-m-Y') }} @endif" readonly>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Tanggal & Waktu Turun</label>
                                                <input type="text" class="form-control" name="down_at" value="@if($container->down_at) {{ \Carbon\Carbon::parse($container->down_at)->format('d-m-Y H:i') }}  @endif" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Lokasi Turun</label>
                                                <input type="text" class="form-control" name="down_location_id" value="@if($container->down_location_id) {{ $container->downLocation->name }} @endif" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>No Turun Gerbong</label>
                                                <input type="text" class="form-control" name="down_carriage_no" value="{{ $container->down_carriage_no }}" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Tanggal & Waktu Naik</label>
                                                <input type="text" class="form-control" name="down_at" value="@if($container->up_at) {{ \Carbon\Carbon::parse($container->up_at)->format('d-m-Y H:i') }}  @endif" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Lokasi Naik</label>
                                                <input type="text" class="form-control" name="up_location_id" value="@if($container->up_location_id) {{ $container->upLocation->name }} @endif" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>No Naik Gerbong</label>
                                                <input type="text" class="form-control" name="up_carriage_no" value="{{ $container->up_carriage_no }}" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Dibuat Oleh</label>
                                        <input type="text" class="form-control" name="created_by" value="{{ $container->admin->name }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
