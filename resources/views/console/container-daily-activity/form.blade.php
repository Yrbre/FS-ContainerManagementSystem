<div class="col-lg-12">
    <div class="form-group mb-3">
        <label for="location_id">Lokasi</label>
        <select name="location_id" class="form-control select2 @error('location_id') is-invalid @enderror" id="location_id">
            @foreach ($locations as $l)
                <option value="{{ $l->id }}" @if (isset($containerDailyActivity)) @if($containerDailyActivity->location_id == $l->id) selected  @endif @endif>{{ $l->code }}</option>
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
        <input name="action_date" type="datetime-local" class="form-control @error('action_date') is-invalid @enderror" id="action_date"  value="{{  old('action_date') ?? (!isset($containerDailyActivity) ? '' : $containerDailyActivity->action_date) }}">
        @error('action_date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>