<div class="col-lg-12">
    <div class="form-group mb-3">
        <label for="name">Nama satuan</label>
        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="ex: centi meter" value="{{  old('name') ?? (!isset($unit) ? '' : $unit->name) }}">
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="symbol">Symbol</label>
        <input name="symbol" type="text" class="form-control @error('symbol') is-invalid @enderror" id="symbol" placeholder="ex: cm" value="{{  old('symbol') ?? (!isset($unit) ? '' : $unit->symbol) }}">
        @error('symbol')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>