<div class="col-lg-12">
    <div class="form-group mb-3">
        <label for="Kode Erp">Kode ERP</label>
        <input name="erp_code" type="text" class="form-control @error('erp_code') is-invalid @enderror" id="erp_code" placeholder="Kode Erp" value="{{  old('erp_code') ?? (!isset($vendor) ? '' : $vendor->erp_code) }}">
        @error('erp_code')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="name">Nama {{strtolower($content_title)}}</label>
        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="CTC Group" value="{{  old('name') ?? (!isset($vendor) ? '' : $vendor->name) }}">
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="Address">Alamat utama</label>
        <textarea name="address_1" id="address_1" class="form-control @error('address_1') is-invalid @enderror" rows="5" placeholder="Jl Lexa II, Ds. Kampung biru">{{  old('address_1') ?? (!isset($vendor) ? '' : $vendor->address_1) }}</textarea>

        @error('address_1')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="Address">Alamat 2 <small class="text-danger">(optional)</small></label>
        <textarea name="address_2" id="address_2" class="form-control @error('address_2') is-invalid @enderror" rows="5" placeholder="Jl Lexa II, Ds. Kampung biru">{{  old('address_2') ?? (!isset($vendor) ? '' : $vendor->address_2) }}</textarea>

        @error('address_2')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="Address">Alamat 3 <small class="text-danger">(optional)</small></label>
        <textarea name="address_3" id="address_3" class="form-control @error('address_3') is-invalid @enderror" rows="5" placeholder="Jl Lexa II, Ds. Kampung biru">{{  old('address_3') ?? (!isset($vendor) ? '' : $vendor->address_3) }}</textarea>

        @error('address_3')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    
</div>