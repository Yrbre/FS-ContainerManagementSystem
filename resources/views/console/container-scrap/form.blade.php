<div class="col-lg-12">
    <div class="form-group mb-3">
        <label for="location_id">Lokasi</label>
        <select name="location_id" class="form-control select2 @error('location_id') is-invalid @enderror" id="location_id">
            <option value="">-- Pilih Lokasi --</option>
            @foreach ($locations as $l)
                <option value="{{ $l->id }}" @if (isset($ctScrap)) @if($ctScrap->location_id == $l->id) selected  @endif @endif>{{ $l->code }}</option>
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
        <input name="action_date" type="datetime-local" class="form-control @error('action_date') is-invalid @enderror" id="action_date"  value="{{  old('action_date') ?? (!isset($ctScrap) ? '' : $ctScrap->action_date) }}">
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
                <option value="{{ $v->id }}" @if (isset($ctScrap)) @if($ctScrap->vendor_id == $v->id) selected  @endif @endif>{{ $v->name }}</option>
            @endforeach
        </select>
        @error('vendor_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="documents">Documents</label>
        <input class="form-control @error('documents') is-invalid @enderror" name="documents[]" type="file" multiple/>
        @error('documents')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="description">Keterangan Scrap</label>
        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" cols="30" rows="5" placeholder="Contoh: Kerusakan memenuhi persyaratan scrap">{{  old('description') ?? (!isset($ctScrap) ? '' : $ctScrap->description) }}</textarea>
        @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

</div>