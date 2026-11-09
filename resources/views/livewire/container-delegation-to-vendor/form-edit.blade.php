<div>
    <form wire:submit.prevent="submit">        
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="form-group mb-3">
                    <label for="location_id">Lokasi</label>
                    <select wire:model="location_id" class="form-control @error('location_id') is-invalid @enderror" id="location_id">
                        <option>-- pilih lokasi --</option>
                        @foreach ($locations as $l)
                            <option wire:key="{{ $loop->iteration }}" value="{{ $l->id }}" @if (isset($containerDelegation)) @if($containerDelegation->location_id == $l->id) selected  @endif @endif>{{ $l->code }}</option>
                        @endforeach
                    </select>
                    @error('location_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
    
                <div class="form-group mb-3">
                    <label for="action_date">Tanggal & Waktu</label>
                    <input wire:model="action_date" type="datetime-local" class="form-control @error('action_date') is-invalid @enderror" id="action_date"  value="{{  old('action_date') ?? (!isset($containerDelegation) ? '' : $containerDelegation->action_date) }}">
                    @error('action_date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="job_type">Tipe Transaksi</label>
                    <select wire:model="job_type" class="form-control @error('job_type') is-invalid @enderror" id="job_type">
                        <option>-- Pilih Tipe --</option>
                        <option value="Maintenance" @if(isset($containerDelegation)) @if($containerDelegation->job_type == 'Maintenance') selected @endif @endif>Maintenance</option>
                        <option value="Upgrade & Repair" @if(isset($containerDelegation)) @if($containerDelegation->job_type == 'Upgrade & Repair') selected @endif @endif>Upgrade & Repair</option>
                    </select>
                    @error('job_type')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
    
                <div class="form-group mb-3">
                    <label for="vendor_id">Vendor</label>
                    <select wire:ignore wire:model="vendor_id" id="vendor_id" class="form-control @error('vendor_id') is-invalid @enderror">
                        <option value="">-- Pilih Vendor --</option>
                        @foreach ($vendors as $vendor)
                            <option value="{{ $vendor->id }}" @if (isset($containerDelegation)) @if($containerDelegation->vendor_id == $vendor->id) selected @endif @endif>{{ $vendor->name }}</option>
                        @endforeach
                    </select>
                    @error('vendor_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
    
                @if ($vendor_id)
                    <div class="form-group mb-3">
                        <label for="contract_id">Kontrak</label>
                        <select wire:model="contract_id" id="contract_id" class="form-control @error('contract_id') is-invalid @enderror">
                            <option value="">-- Pilih Kontrak --</option>
                            @foreach ($contracts as $contract)
                                <option value="{{ $contract->id }}" @if (isset($containerDelegation)) @if($containerDelegation->contract_id == $contract->id) selected @endif @endif>{{ $contract->code }}</option>
                            @endforeach
                        </select>
                        @error('contract_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                @endif
                
                
            </div>
            <div class="col-12 col-sm-12 col-md-12 d-flex justify-content-end">
                <a href="{{ route('console.delegation-to-vendor.index') }}" class="btn btn-outline-primary text-dark mr-2">Cancel</a>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </form>
</div>