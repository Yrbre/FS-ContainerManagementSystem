<div>
    {{-- Be like water. --}}
    <div class="row justify-content-center">
        @foreach ($records as $rec)
            @if ($rec->code)
                <div class="col-lg-6 mt-2">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title text-center">
                                <strong>{{ $rec->code == null ? '-' : $rec->code }}</strong>
                            </h4>
                            <p class="card-text text-center">Latest CT Activity :
                                {{ $rec->action_date == null ? '-' : \Carbon\Carbon::parse($rec->action_date)->format('d-m-Y H:i') }}
                                <span class="badge badge-success">{{ $rec->type == null ? '-' : $rec->type }}</span>
                            </p>
                        </div>
                        <div class="card-footer text-center">
                            <a href="#" class="btn btn-secondary text-center"
                                wire:click="showModal('{{ $rec->id }}', 'TSO')"><strong>TSO :
                                    {{ $rec->tso_count }}</strong></a>
                            <a href="#" class="btn btn-primary"
                                wire:click="showModal('{{ $rec->id }}', 'SO')"><strong>SO :
                                    {{ $rec->so_count }}</strong></a>
                            @if ($rec->code == 'BBA' || $rec->code == 'BJI')
                                <a href="#" class="btn btn-info"
                                    wire:click="showModal('{{ $rec->id }}', 'SOI')"><strong>SO (Isi) :
                                        {{ $rec->soi_count }}</strong></a>
                                <a href="#" class="btn btn-warning"
                                    wire:click="showModal('{{ $rec->id }}', 'TSOI')"><strong>TSO (Isi) :
                                        {{ $rec->tsoi_count }}</strong></a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
    <br>
    <hr class="border border-primary">
    <livewire:dashboard.livewire-charts />

    <!-- Modal -->
    <div class="modal fade" id="containerModal" tabindex="-1" aria-labelledby="containerModalLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="containerModalLabel">Container Detail
                        {{-- {{ isset($state['containers']) ? count($state['containers']) : '' }}</h5> --}}
                        <a href="#" class="btn btn-info"
                            wire:click="showModalMaintenance('{{ $state['location'] ?? '0' }}', '{{ $state['status'] ?? ' ' }}', 'Maintenance')"><strong>Maintenance
                                :
                                {{ isset($state['total_maintenance']) ? $state['total_maintenance'] : '0' }}</strong></a>
                        <a href="#" class="btn btn-warning"
                            wire:click="showModalMaintenance('{{ $state['location'] ?? '0' }}', '{{ $state['status'] ?? ' ' }}', 'Upgrade & Repair')"><strong>Upgrade
                                & Repair :
                                {{ isset($state['total_upgrade']) ? $state['total_upgrade'] : '0' }}</strong></a>
                        {{-- if location is BJI and Status is SO --}}
                        @if (isset($state) && $state['location'] == 3 && $state['status'] == 'SO')
                            <a href="#" class="btn btn-danger"
                                wire:click="showModalMaintenance('{{ $state['location'] ?? '0' }}', '{{ $state['status'] ?? ' ' }}', 'CT-DT')"><strong>CT-DT
                                    :
                                    {{ isset($state['ct_dt']) ? $state['ct_dt'] : '0' }}</strong></a>
                        @endif
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-responsive-lg">
                                <thead>
                                    <tr>
                                        <th scope="col">No CT</th>
                                        <th scope="col">Company</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Lokasi</th>
                                        <th scope="col">Tgl Inspeksi</th>
                                        <th scope="col">Tgl BAST1</th>
                                        <th scope="col">Tgl BAST2</th>
                                        <th scope="col">Vendor</th>
                                        <th scope="col">Detail Perbaikan</th>
                                        <th scope="col">Progress (%)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($state['containers']))
                                        @forelse ($state['containers'] as $ct)
                                            <tr>
                                                <td>
                                                    {{ $ct->code }}
                                                </td>
                                                <td>{{ $ct->company->name }}</td>
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
                                                    {{ $ct->downLocation->code ?? '-' }}
                                                </td>
                                                <td>
                                                    {{ isset($ct->latestInspection) ? \Carbon\Carbon::parse($ct->latestInspection->created_at)->format('d-m-Y') : '-' }}
                                                </td>
                                                <td>{{ isset($ct->latestBastToVendor) && $ct->latestBastToVendor->created_at >= $ct->latestInspection->created_at ? \Carbon\Carbon::parse($ct->latestBastToVendor->created_at)->format('d-m-Y') : '-' }}
                                                </td>
                                                <td>{{ isset($ct->latestBastFromVendor) && $ct->latestBastFromVendor->created_at >= $ct->latestBastToVendor->created_at ? \Carbon\Carbon::parse($ct->latestBastFromVendor->created_at)->format('d-m-Y') : '-' }}
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
                                                <td>
                                                    @if (@isset($ct->latestDelegationFromVendorDetail->sub) && $ct->last_type_maintenance == 'Maintenance')
                                                        @foreach ($ct->latestDelegationFromVendorDetail->sub as $index => $subDetail)
                                                            {{ $loop->iteration }}.
                                                            {{ $subDetail->job_type ?? '-' }}<br>
                                                        @endforeach
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (isset($ct->latestRepair) && $ct->latestRepair->created_at > $ct->latestInspection->created_at)
                                                        @if ($ct->latestRepair->repair->status != 'DRAFT')
                                                            {{ $ct_progress = \App\Models\ContainerRepairDetail::select('container_repairs.status', 'container_repair_details.*')->join('container_repairs', 'container_repair_details.container_repair_id', 'container_repairs.id')->where('container_repair_details.container_code', $ct->code)->where('container_repairs.status', '!=', 'DRAFT')->latest()->first()->progress }}%
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
                                                <td colspan="11">Opps! Data tidak ditemukan.</td>
                                            </tr>
                                        @endforelse
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        wire:click="closeModal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $('.apexcharts-xaxis').hide();
    </script>
    <script>
        window.addEventListener('show-modal', event => {
            $('#containerModal').modal('show');
        })

        window.addEventListener('close-modal', event => {
            $('#containerModal').modal('hide');
        })
    </script>
@endpush
</div>
