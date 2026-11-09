<div>
    <div class="row">
        {{-- input filter by company --}}
        <div class="col-lg-12">

            <div class="row mb-2">
                <div class="col-sm-4 col-md-4 col-lg-4">
                    <div class="form-group">
                        <label for=""> <strong> FILTER BY: </strong></label>
                    </div>
                </div>

                <div class="col-sm-8 col-md-8 col-lg-8 d-flex flex-column">
                    <button class="btn btn-primary align-self-end" wire:click="export">Export Ke Excel</button>
                </div>
            </div>

            <div class="row">
                <div class="col-lg">
                    <div class="form-group">
                        <label for="company">Perusahaan</label>
                        <select wire:model="company" class="form-control" id="company">
                            <option value="">--- Pilih Perusahaan ---</option>
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-lg">
                    <div class="form-group">
                        <label for="Vendor Beli">Vendor Beli</label>
                        <select wire:model="vendor_buy" class="form-control" id="company">
                            <option value="">--- Pilih Vendor ---</option>
                            @foreach ($vendors as $vendor)
                                <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-lg">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select wire:model="status" class="form-control" id="status">
                            <option value="">--- Pilih Status ---</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status->code }}">{{ $status->code }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-lg">
                    <div class="form-group">
                        <label for="location">Lokasi</label>
                        <select wire:model="location" class="form-control" id="location">
                            <option value="">--- Pilih Lokasi ---</option>
                            @foreach ($locations as $location)
                                <option value="{{ $location->id }}">{{ $location->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-lg">
                    <div class="form-group">
                        <label for="vendor">Vendor Maintenance / Upgrade</label>
                        <select wire:model="vendor_repair" class="form-control" id="vendor">
                            <option value="">--- Pilih Vendor ---</option>
                            @foreach ($vendors as $vendor)
                                <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <hr class="border border-primary">

    <div class="row">
        <div class="col-lg-12">

            <ul class="list-group mb-3">
                <li class="list-group-item list-group-item-info" aria-current="true"><strong>Ditemukan
                        {{ number_format($containers->total(), 0) }} data</strong></li>
            </ul>

            <div class="table-responsive">
                <table class="table table-responsive-lg">
                    <thead>
                        <tr>
                            <th scope="col">No CT</th>
                            <th scope="col">Company</th>
                            <th scope="col">Tgl Pembelian</th>
                            <th scope="col">Garansi s/d</th>
                            <th scope="col">Vendor Garansi</th>
                            <th scope="col">Status</th>
                            <th scope="col">Lokasi</th>
                            <th scope="col">Tgl Inspeksi</th>
                            <th scope="col">Tgl Bast Ke Vendor</th>
                            <th scope="col">Vendor Maintenance/Upgrade</th>
                            <th scope="col">Progress (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($containers as $ct)

                            <tr>
                                <td>
                                    {{ $ct->code }}
                                </td>
                                <td>{{ $ct->company->name }}</td>
                                <td>{{ DateHelper::format($ct->buy_date) ?? '-' }}</td>
                                <td>{{ $ct->warranty_date_start
                                    ? \Carbon\Carbon::parse($ct->warranty_date_start)->format('d-m-Y') .
                                        ' s/d ' .
                                        \Carbon\Carbon::parse($ct->warranty_date_end)->format('d-m-Y')
                                    : '-' }}
                                </td>
                                <td>{{ $ct->vendor->name }}</td>
                                <td>
                                    @if ($ct->status->code == 'TSO')
                                        @if ($ct->last_type_maintenance == 'Maintenance')
                                            TSO (M)
                                        @elseif($ct->last_type_maintenance == 'Upgrade & Repair')
                                            TSO (U)
                                        @else
                                            TSO
                                        @endif
                                    @else
                                        {{ $ct->status->code }}
                                    @endif
                                </td>
                                <td>
                                    {{-- @if (isset($ct->status))
                                    @if ($ct->status->code == 'SO') 
                                        {{$ct->upLocation->code ?? '-'}}
                                    @elseif($ct->status->code == 'TSO')
                                        {{$ct->downLocation->code ?? '-'}}
                                    @else
                                        -
                                    @endif
                               @endif --}}
                                    {{ $ct->downLocation->code ?? '-' }}

                                </td>
                                <td>
                                    {{ isset($ct->latestInspection)
                                        ? \Carbon\Carbon::parse($ct->latestInspection->created_at)->format('d-m-Y')
                                        : '-' }}
                                </td>
                                <td>{{ isset($ct->latestBastToVendor) && $ct->latestBastToVendor->created_at > $ct->latestInspection->created_at
                                    ? \Carbon\Carbon::parse($ct->latestBastToVendor->created_at)->format('d-m-Y')
                                    : '-' }}
                                </td>
                                <td>
                                    @if (($ct->last_type_maintenance == 'Maintenance' && $ct->status->code == 'TSO') || $ct->status->code == 'SO')
                                        {{ $ct->lastMaintenanceVendor->name }}
                                    @elseif(($ct->last_type_maintenance == 'Upgrade & Repair' && $ct->status->code == 'TSO') || $ct->status->code == 'SO')
                                        {{ $ct->lastUpgradeVendor->name }}
                                    @else
                                        -
                                    @endif

                                </td>
                                {{-- <td>{{ $ct->repairDetail->progress ?? '0' }} %</td>                       --}}
                                {{-- \App\Models\Vendor::find($vendor)->contracts()->get() as $c --}}
                                <td>
                                    @if (isset($ct->latestRepair) && $ct->latestRepair->created_at > $ct->latestBastToVendor->created_at)
                                        @if ($ct->latestRepair->repair->status != 'DRAFT')
                                            {{ $ct_progress = \App\Models\ContainerRepairDetail::select(
                                                'container_repairs.status',
                                                'container_repair_details.*',
                                            )->join('container_repairs', 'container_repair_details.container_repair_id', 'container_repairs.id')->where('container_repair_details.container_code', $ct->code)->where('container_repairs.status', '!=', 'DRAFT')->latest()->first()->progress }}
                                            %
                                        @else
                                            0.00 %
                                        @endif
                                    @else
                                        0.00 %
                                    @endif
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="11">Opps! Data tidak di temukan.</td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>
            </div>
            <div class="d-flex justify-content-end">
                {{ $containers->links() }}
            </div>
        </div>
    </div>


</div>
