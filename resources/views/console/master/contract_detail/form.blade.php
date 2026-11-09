<div class="col-lg-12">
    <div class="form-group mb-3">
        <label for="Kode Erp">Nomor Kontrak</label>
        <input name="contract_code" type="text" class="form-control" value="{{$contract->code}}" id="contract_code"  disabled>
    </div>

    <div class="form-group mb-3">
        <label class="font-weight-bold m-0">Vendor</label>
        <input name="" type="text" class="form-control" value="{{$contract->vendor->name}}" id=""  disabled>
    </div>

    <div class="form-group mb-3">
        <label class="font-weight-bold m-0">Subject</label>
        <input name="" type="text" class="form-control" value="{{$contract->subject}}" id=""  disabled>
    </div>

    <div class="form-group mb-3">
        <label class="font-weight-bold m-0">Tipe Kontrak</label>
        <input name="" type="text" class="form-control" value="{{$contract->type}}" id=""  disabled>
    </div>

    <div class="form-group mb-3">
        <label for="Jenis pekerjaan">Jenis Pekerjaan</label>
        <input name="job_type" type="text" class="form-control @error('job_type') is-invalid @enderror" id="job_type" placeholder="Ganti kunci" value="{{  old('job_type') ?? (!isset($contractDetail) ? '' : $contractDetail->job_type) }}">
        @error('job_type')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>


    <div class="form-group mb-3">
        <label for="Unit">Satuan</label>
        <select class="form-select @error('unit') is-invalid @enderror" name="unit" aria-label="Default select example">
            @isset($contractDetail) 
                <option value="" disabled>Pilih unit ...</option>
                @foreach ($units as $unit)
                    <option value="{{ $unit->id }}" {{ $unit->id == $contractDetail->unit_id ? 'selected' : '' }}>{{ $unit->name }}</option>
                @endforeach
            @else
                <option value="" disabled selected>Pilih unit ...</option>
                @foreach ($units as $unit)
                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                @endforeach
            @endisset   
        </select>
        @error('unit')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="Harga satuan">Harga Satuan</label>
        <input name="price" type="number" class="form-control @error('price') is-invalid @enderror" id="price" placeholder="Harga satuan" value="{{  old('price') ?? (!isset($contractDetail) ? '' : $contractDetail->price) }}">
        @error('price')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>  

    <div class="form-group mb-3">
        <label for="Qty">Kuantitas</label>
        <input name="qty" type="number" class="form-control @error('qty') is-invalid @enderror" id="qty"  value="{{  old('qty') ?? (!isset($contractDetail) ? '' : $contractDetail->qty) }}">
        @error('qty')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="working_duration">Waktu pengerjaan dalam hari <small class="text-danger">(Opsional)</span></label>
        <input name="working_duration" type="number" class="form-control @error('working_duration') is-invalid @enderror" placeholder="Berapa hari?" id="working_duration"  value="{{  old('working_duration') ?? (!isset($contractDetail) ? '' : $contractDetail->working_duration) }}">
        @error('working_duration')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>


     
</div>