<div class="col-lg-12">
    <div class="form-group mb-3">
        <label for="name">Lokasi</label>
        

            <select name="location_id" class="form-control select2 @error('location_id') is-invalid @enderror" id="location_id">
                @foreach ($locations as $r)
                    <option value="{{ $r->id }}">{{ $r->code }}</option>
                @endforeach
            </select>
            
        @error('location_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>


    <div class="form-group mb-3">
        <label for="name">Vendor</label>
        <select name="vendor_id" class="form-control select2 @error('vendor_id') is-invalid @enderror" id="vendor_id">

            @foreach ($vendors as $r)
                <option value="{{ $r->id }}">{{ $r->name }}</option>
            @endforeach

        </select>
        @error('vendor_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="action_date">Tanggal & Waktu</label>
        <input name="action_date" type="datetime-local" class="form-control @error('action_date') is-invalid @enderror" id="action_date"  value="{{  old('action_date') ?? (!isset($containerRepair) ? '' : $containerRepair->action_date) }}">
        @error('action_date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>


    <div class="form-group mb-3">
        <label for="description">Keterangan perbaikan</label>
        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" cols="30" rows="5" placeholder="Contoh: Ada kendalah bahan">{{  old('description') ?? (!isset($containerRepair) ? '' : $containerRepair->description) }}</textarea>
        @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

  
</div>