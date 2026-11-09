<div>
    @can(['Checker'])
        @if ($containerDailyActivity->status == 'DRAFT')
            <button class="btn btn-info" type="button" wire:click="openModal">
                <i class="material-icons">add</i>
            </button>
        @endif
    @endcan

    @can(['Administrator', 'Checker'])
        @if ($containerDailyActivity->status == 'DRAFT' && $location == 'BJI')
            <button class="btn btn-info" type="button" wire:click="openModalUpload">
                <i class="material-icons">upload</i>
            </button>
        @endif
    @endcan

    {{-- Start Modal --}}
    @if ($openModalActivity == true)
        <div class="modal fade show d-block" id="addDetailDailyActivityModal" tabindex="-1" role="dialog"
            aria-labelledby="dailyActivityModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="dailyActivityModalLabel">Tambah Detail Aktivitas Harian</h5>
                        <button type="button" class="close" wire:click="closeModal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @include('partials.alert')

                        <div class="form-group">
                            <label class="font-weight-bold">Tipe Aktivitas</label>
                            <select class="form-control @error('type') is-invalid @enderror" wire:model="type">
                                <option value="">-- pilih aktivitas --</option>
                                <option value="Turun Container">Turun Container</option>
                                <option value="Naik Container">Naik Container</option>
                                <option value="Putus Gerbong">Putus Gerbong / Tukar CT</option>
                                @if ($location == 'BJI' || $location == 'BBA')
                                    <option value="CT-DT">BJI - CT-DT</option>
                                    <option value="Truck Unloading">BJI - Truck Unloading</option>
                                    {{-- <option value="Container Uplift">BJI - Container Uplift</option> --}}
                                    <option value="Container Unloading">BJI - Container Unloading</option>
                                @endif
                            </select>
                            @error('type')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        @if ($type)
                            <div class="form-group">
                                <label class="font-weight-bold">Pilih Kontainer</label>
                                <select
                                    class="form-control select2-custom @error('selected_container') is-invalid @enderror"
                                    wire:model="selected_container">
                                    <option value="">-- pilih container --</option>
                                    @if ($containers)
                                        @foreach ($containers as $c)
                                            <option value="{{ $c->code }}"
                                                {{ $selected_container == $c->code ? 'selected' : null }}>
                                                {{ $c->code }}
                                                @if ($type == 'Naik Container')
                                                    ({{ $c->status->code }})
                                                @endif
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('selected_container')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif

                        <div class="form-group">
                            <label class="font-weight-bold m-0">Nomor Gerbong Datar / Truck</label>
                            <input class="form-control @error('carriage_number') is-invalid @enderror"
                                wire:model="carriage_number" type="text" />
                            @error('carriage_number')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold m-0">Tujuan/Asal Kontainer</label>
                            <select class="form-control select2-custom @error('container_source') is-invalid @enderror"
                                wire:model="container_source">
                                <option value="">-- Pilih Tujuan/Asal Kontainer--</option>
                                <option value="Upgrade / Repair">Upgrade / Repair</option>
                                <option value="Maintenance">Maintenance</option>
                                <option value="Buffer">Buffer</option>
                                <option value="Operasional">Operasional</option>

                            </select>
                            @error('container_source')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold m-0">No. TS Tujuan</label>
                            @if ($type == 'Naik Container')
                                <select
                                    class="form-control select2-custom @error('trainset_number') is-invalid @enderror"
                                    wire:model="trainset_number">
                                    <option value="">-- Pilih Tujuan TS--</option>
                                    <option value="SIG 24">SIG 24</option>
                                    <option value="SIG 22">SIG 22</option>
                                    <option value="SIG 9">SIG 9</option>
                                    <option value="SIG 14">SIG 14</option>
                                    <option value="KPT 3/4">KPT 3/4</option>
                                </select>
                            @else
                                <input class="form-control @error('trainset_number') is-invalid @enderror"
                                    wire:model="trainset_number" type="text" value="-" readonly />
                            @endif
                            @error('trainset_number')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal">Close</button>
                        <button type="button" wire:click.prevent="submit" class="btn btn-primary"
                            @if ($upTSO) onclick="return confirm('Container dengan STATUS TSO akan di naikan, Apakah yakin?') || event.stopImmediatePropagation()" @endif>Save</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-backdrop show fade"></div>
    @endif

    @if ($openModalUpload == true)
        <div class="modal fade show d-block" id="addDetailDailyActivityModalUpload" tabindex="-1" role="dialog"
            aria-labelledby="dailyActivityModalLabelUpload" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="dailyActivityModalLabelUpload">Upload Detail Aktivitas Harian</h5>
                        <button type="button" class="close" wire:click="closeModalUpload">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @include('partials.alert')
                        <div class="form-group">
                            <form wire:submit.prevent="upload" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="file">Upload Excel File:</label>
                                    <input type="file" class="form-control" wire:model="file" id="file">
                                    @error('file')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <div class="form-group">
                                        <div wire:loading wire:target="file">Mohon tunggu file sedang diproses...
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Upload</button>
                            </form>
                            @error('type')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModalUpload">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-backdrop show fade"></div>
    @endif
    {{-- End Modal --}}
</div>

@push('scripts')
    @if ($openModalActivity == true)
        <script>
            $(function() {
                $('.select2-custom').select2({
                    theme: "bootstrap",
                    dropdownParent: $('#addDetailDailyActivityModal')
                });
            });
        </script>
    @endif
@endpush
