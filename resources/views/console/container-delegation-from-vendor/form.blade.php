<div class="col-lg-12">
    <div class="form-group mb-3">
        <label for="location_id">Lokasi</label>
        <select name="location_id" class="form-control select2 @error('location_id') is-invalid @enderror" id="location_id">
            <option value="">-- Pilih Lokasi --</option>
            @foreach ($locations as $l)
                <option value="{{ $l->id }}" @if (isset($delegationFromVendor)) @if($delegationFromVendor->location_id == $l->id) selected  @endif @endif>{{ $l->code }}</option>
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
        <input name="action_date" type="datetime-local" class="form-control @error('action_date') is-invalid @enderror" id="action_date"  value="{{  old('action_date') ?? (!isset($delegationFromVendor) ? '' : $delegationFromVendor->action_date) }}">
        @error('action_date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="vendor_id">Vendor</label>
        <select name="vendor_id" class="form-control select2 @error('vendor_id') is-invalid @enderror" id="vendor_id">
            <option value="">-- Pilih Vendor --</option>
            @foreach ($vendors as $v)
                <option value="{{ $v->id }}" @if (isset($delegationFromVendor)) @if($delegationFromVendor->vendor_id == $v->id) selected  @endif @endif>{{ $v->name }}</option>
            @endforeach
        </select>
        @error('vendor_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="job_type">Tipe Transaksi</label>
        <select name="job_type" class="form-control select2 @error('job_type') is-invalid @enderror" id="job_type">
            <option value="">-- Pilih Tipe --</option>
            <option value="Maintenance" @if(isset($delegationFromVendor)) @if($delegationFromVendor->job_type == 'Maintenance') selected @endif @endif>Maintenance</option>
            <option value="Upgrade & Repair" @if(isset($delegationFromVendor)) @if($delegationFromVendor->job_type == 'Upgrade & Repair') selected @endif @endif>Upgrade & Repair</option>
        </select>
        @error('job_type')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>