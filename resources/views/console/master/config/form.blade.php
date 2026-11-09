<div class="col-lg-12">
    <div class="form-group mb-3">
        <label for="name">Nama Config</label>
        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name"
            placeholder="ex: whatsapp-notif" value="{{ old('name') ?? (!isset($config) ? '' : $config->name) }}">
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="status">Status</label>
        <select name="status" class="form-control @error('status') is-invalid @enderror" id="status">
            <option value="1"
                {{ old('status') == '1' || (isset($config) && $config->status == 1) ? 'selected' : '' }}>Active</option>
            <option value="0"
                {{ old('status') == '0' || (isset($config) && $config->status == 0) ? 'selected' : '' }}>Non-active
            </option>
        </select>
        @error('status')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>


</div>
