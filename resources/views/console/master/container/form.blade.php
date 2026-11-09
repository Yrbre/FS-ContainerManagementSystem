<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label>Nomor CT</label>
            @if (isset($container))
                @if (route('console.container.update', $container))
                    <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ $container->code }}" readonly>
                @endif
            @else
                <input class="form-control @error('code') is-invalid @enderror" type="text"
                    name="code" value="{{ old('code') ?? (!isset($container) ? '' : $container->code) }}" />
            @endif
            @error('code')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        
        <div class="form-group">
            <label>No Fixed Asset</label>
            <input class="form-control @error('fixed_asset_number') is-invalid @enderror"
                type="text" name="fixed_asset_number" value="{{ old('fixed_asset_number') ?? (!isset($container) ? '' : $container->fixed_asset_number) }}" />
            @error('fixed_asset_number')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        
        <div class="form-group">
            <label>Vendor Pembelian</label>
            <select name="vendor_id" class="form-control  @error('vendor_id') is-invalid @enderror">
                <option value="">-- pilih --</option>
                @foreach ($vendors as $v)
                    @if (!isset($container))    
                        <option value="{{ $v->id }}"
                            {{ old('vendor_id') == $v->id ? 'selected' : null }}>{{ $v->name }}
                        </option>
                    @else
                        <option value="{{ $v->id }}" @if ($container->vendor_id == $v->id) selected  @endif >{{ $v->name }}
                        </option>
                    @endif
                @endforeach
            </select>
            @error('vendor_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        
        <div class="form-group">
            <label>Tanggal Pembelian</label>
            <input class="form-control @error('buy_date') is-invalid @enderror" type="date"
                name="buy_date" value="{{ old('buy_date') ?? (!isset($container)) ? old('buy_date') : ($container->buy_date ? \Carbon\Carbon::parse($container->buy_date)->format('Y-m-d') : '') }}"/>
            @error('buy_date')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        
        <div class="form-group">
            <label>Vendor Upgrade & Repair terkahir</label>
            <select name="last_upgrade_vendor_id" class="form-control  @error('last_upgrade_vendor_id') is-invalid @enderror">
                <option value="">-- pilih --</option>
                @foreach ($vendors as $v)
                    @if (!isset($container))    
                        <option value="{{ $v->id }}"
                            {{ old('last_upgrade_vendor_id') == $v->id ? 'selected' : null }}>
                            {{ $v->name }}
                        </option>
                    @else
                        <option value="{{ $v->id }}" @if ($container->last_upgrade_vendor_id == $v->id) selected  @endif >{{ $v->name }}
                        </option>
                    @endif
                @endforeach
            </select>
            @error('last_upgrade_vendor_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        
        <div class="form-group">
            <label>Tanggal Upgrade & Repair Terakhir</label>
            <input class="form-control @error('last_upgrade_date') is-invalid @enderror" type="date" name="last_upgrade_date" value="{{ old('last_upgrade_date') ?? (!isset($container)) ? old('last_upgrade_date') : ($container->last_upgrade_date ? \Carbon\Carbon::parse($container->last_upgrade_date)->format('Y-m-d') : '') }}" />
            @error('last_upgrade_date')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        
        <div class="form-group">
            <label>Vendor Maintenance terkahir</label>
            <select name="last_maintenance_vendor_id" class="form-control  @error('last_maintenance_vendor_id') is-invalid @enderror">
                <option value="">-- pilih --</option>
                @foreach ($vendors as $v)
                    @if (!isset($container))    
                        <option value="{{ $v->id }}"
                            {{ old('last_maintenance_vendor_id') == $v->id ? 'selected' : null }}>
                            {{ $v->name }}
                        </option>
                    @else
                        <option value="{{ $v->id }}" @if ($container->last_maintenance_vendor_id == $v->id) selected  @endif >{{ $v->name }}
                        </option>
                    @endif
                @endforeach
            </select>
            @error('last_maintenance_vendor_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        
        <div class="form-group">
            <label>Tanggal Maintenance Terakhir</label>
            <input class="form-control @error('last_maintenance_date') is-invalid @enderror" type="date"
                name="last_maintenance_date" value="{{  old('last_maintenance_date') ?? (!isset($container)) ? old('last_maintenance_date') : ($container->last_maintenance_date ? \Carbon\Carbon::parse($container->last_maintenance_date)->format('Y-m-d') : '') }}" />
            @error('last_maintenance_date')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group">
            <label>Nomor Kontrak</label>
            <select class="form-control select2 @error('contract_id') is-invalid @enderror"
                name="contract_id">
                <option value="">-- pilih --</option>
                @foreach ($contracts as $v)
                    @if (!isset($container))    
                        <option value="{{ $v->id }}"
                            {{ old('contract_id') == $v->id ? 'selected' : null }}>{{ $v->code }}
                        </option>
                    @else
                        <option value="{{ $v->id }}" @if ($container->contract_id == $v->id) selected  @endif >{{ $v->code }}
                        </option>
                    @endif
                @endforeach
            </select>

            @error('contract_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        
        <div class="form-group">
            <label>Perusahaan</label>
            <select class="form-control  @error('company_id') is-invalid @enderror"
                name="company_id">
                <option value="">-- pilih --</option>
                @foreach ($companies as $v)
                    @if (!isset($container))    
                        <option value="{{ $v->id }}"
                            {{ old('company_id') == $v->id ? 'selected' : null }}>{{ $v->name }}
                        </option>
                    @else
                        <option value="{{ $v->id }}" @if ($container->company_id == $v->id) selected  @endif >{{ $v->name }}
                        </option>
                    @endif
                @endforeach
            </select>
            @error('company_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label>Panjang</label>
                    <div class="input-group">
                        <input class="form-control @error('length') is-invalid @enderror" type="number"
                            name="length" value="{{ old('length') ?? (!isset($container) ? '' : $container->length) }}" />
                        
                        <div class="input-group-append">
                            <span class="input-group-text">cm</span>
                        </div>
                    </div>
                    @error('length')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            
            <div class="col">
                <div class="form-group">
                    <label>Tinggi</label>
                    <div class="input-group">
                        <input class="form-control @error('height') is-invalid @enderror" type="number"
                            name="height" value="{{ old('height') ?? (!isset($container) ? '' : $container->height) }}" />
                        
                        <div class="input-group-append">
                            <span class="input-group-text">cm</span>
                        </div>
                    </div>
                    @error('height')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            
            <div class="col">
                <div class="form-group">
                    <label>Lebar</label>
                    <div class="input-group">
                        <input class="form-control @error('width') is-invalid @enderror" type="number"
                            name="width" value="{{ old('width') ?? (!isset($container) ? '' : $container->height) }}" />

                        <div class="input-group-append">
                            <span class="input-group-text">cm</span>
                        </div>
                    </div>
                    @error('width')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <label>Deskripsi</label>
            <textarea class="form-control @error('description') is-invalid @enderror" name="description"  rows="8"
            >{{ old('description') ?? (!isset($container) ? '' : $container->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        
        <div class="form-group">
            <label>Foto</label>
            <input class="form-control @error('photos') is-invalid @enderror" name="photos[]" type="file" multiple/>
            @error('photos')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        
        <div class="form-group">
            <label>Status</label>
            <input type="hidden" name="container_status_id" value="{{ $container->container_status_id }}">
            <select class="form-control  @error('container_status_id') is-invalid @enderror"
                name="container_status_id" @if (!Auth::user()->hasRole('Administrator'))
                    disabled
                @endif>
                @foreach ($statuses as $v)
                    @if (!isset($container))    
                        <option value="{{ $v->id }}"
                            {{ old('container_status_id') == $v->id ? 'selected' : null }}>{{ $v->description }}
                        </option>
                    @else
                        <option value="{{ $v->id }}" @if ($container->container_status_id == $v->id) selected  @endif >{{ $v->description }}
                        </option>
                    @endif
                @endforeach
            </select>
            @error('container_status_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label>Lokasi</label>
            <select class="form-control  @error('down_location_id') is-invalid @enderror"
                name="down_location_id">
                @isset($container->down_location_id)
                    
                    <option value="-">Pilih Lokasi</option>
                    @foreach ($location as $r)
                        <option value="{{ $r->id }}" {{ $r->id == $container->down_location_id ? 'selected' : '' }}>{{ $r->code }}</option>  
                    @endforeach
                
                @else
                    
                    <option value="-" selected>Pilih Lokasi</option>
                    @foreach ($location as $r)
                        <option value="{{ $r->id }}" >{{ $r->code }}</option>  
                    
                    @endforeach
                
                @endisset
            </select>
            @error('down_location_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
</div>