<div class="col-lg-12">
    <div class="form-group mb-3">
        <label for="code">Kode {{strtolower($content_title)}}</label>
        <input name="code" type="text" class="form-control @error('code') is-invalid @enderror" id="code" placeholder="PLB" value="{{  old('code') ?? (!isset($location) ? '' : $location->code) }}">
        @error('code')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="name">Nama {{strtolower($content_title)}}</label>
        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Palembang" value="{{  old('name') ?? (!isset($location) ? '' : $location->name) }}">
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="address">Alamat {{strtolower($content_title)}}</label>
        <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror" cols="30" rows="5" placeholder="Jl Lexa II, Ds. Kampung biru">{{  old('address') ?? (!isset($location) ? '' : $location->address) }}</textarea>

        @error('address')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>