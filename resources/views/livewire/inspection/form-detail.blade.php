<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Kontainer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div>
            @include('partials.alert')
        </div>
        
        <div class="form-group" wire:ignore>
            <label class="font-weight-bold">Pilih Kontainer</label>
            <select  class="form-control select2-custom2 @error('selected_container') is-invalid @enderror" wire:model="selected_container">
                <option value="">-- pilih container --</option>
                @foreach ($containers as $c)
                    <option value="{{ $c->code }}" {{ $selected_container == $c->code ? 'selected' : null }}>
                        {{ $c->code }}</option>
                @endforeach
            </select>
            @error('selected_container')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        @if ($selected_container)
            {{-- TODO : Read from database --}}
            @php
                $c = \App\Models\Container::find($selected_container);
            @endphp

            <div class="form-group m-0">
                <label class="font-weight-bold m-0">Tanggal Pengadaan</label>
                <input class="form-control-plaintext" value="{{ DateHelper::format($c->buy_date) ?? '-' }}">
            </div>
            <div class="form-group m-0">
                <label class="font-weight-bold m-0">Masa Gransi Pengadaan</label>
                <input class="form-control-plaintext" value="{{ DateHelper::format($c->warranty_date_start) ?? '-' }} s/d {{ DateHelper::format($c->warranty_date_end) ?? '-' }}">
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group m-0">
                        <label class="font-weight-bold m-0">Tanggal Maintenance Terakhir</label>
                        <input class="form-control-plaintext" value="{{ DateHelper::format($c->last_maintenance_date) ?? '-' }}">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group m-0">
                        <label class="font-weight-bold m-0">Vendor Maintenance Terakhir</label>
                        <input class="form-control-plaintext" value="{{ $c->lastMaintenanceVendor->name }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group m-0">
                        <label class="font-weight-bold m-0">Tanggal Upgrade Terakhir</label>
                        <input class="form-control-plaintext" value="{{ DateHelper::format($c->last_upgrade_date) ?? '-' }}">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group m-0">
                        <label class="font-weight-bold m-0">Vendor Upgrade Terakhir</label>
                        <input class="form-control-plaintext" value="{{ $c->lastUpgradeVendor->name }}">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="font-weight-bold m-0">Detail Kerusakan</label>
                <textarea class="form-control @error('damage_description') is-invalid @enderror" wire:model="damage_description"></textarea>
                @error('damage_description')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label class="font-weight-bold m-0">Penyebab Kerusakan</label>
                <textarea class="form-control @error('damage_cause_description') is-invalid @enderror" wire:model="damage_cause_description"></textarea>
                @error('damage_cause_description')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label class="font-weight-bold m-0">Foto Kerusakan</label>
                <input class="form-control @error('images.*') is-invalid @enderror" wire:model="images" type="file" id="upload{{ $iteration }}" multiple/>
                @error('images.*')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
                
                <div class="form-group">
                    <div wire:loading wire:target="images">Mohon tunggu gambar sedang di upload...</div>
                </div>
            </div>
        @endif


    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> 
        <div wire:loading.remove>
            <button type="button" wire:click.prevent="submit" class="btn btn-primary">Save</button>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(function() {
            $('.select2-custom2').select2({
                theme: "bootstrap",
                dropdownParent: $('#addDetailModal')
            });

            $('.select2-custom2').on('change', function(e) {
                @this.set('selected_container', e.target.value);
            });
        });
    </script>
@endpush
