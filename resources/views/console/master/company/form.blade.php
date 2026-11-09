<div class="col-lg-12">
    <div class="form-group mb-3">
        <label for="name">Nama Perusahaan</label>
        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Input nama perusahaan" value="{{  old('name') ?? (!isset($company) ? '' : $company->name) }}">
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="address">Alamat</label>
        <textarea name="address" class="form-control @error('address') is-invalid @enderror" id="" cols="30" rows="10" placeholder="Input alamat perusahaan">{{  old('address') ?? (!isset($company) ? '' : $company->address) }}</textarea>
        @error('address')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="phone_number">Nomor Telepon</label>
        <input name="phone_number" class="form-control @error('phone_number') is-invalid @enderror" value="{{  old('phone_number') ?? (!isset($company) ? '' : $company->phone_number) }}" placeholder="Input nomor telepon">
        @error('phone_number')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>