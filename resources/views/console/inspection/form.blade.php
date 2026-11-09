<div class="col-lg-12">
    <div class="form-group mb-3">
        <label for="name">Lokasi</label>
        @if ($is_edit)
            {{-- <input type="text" class="form-control" value="{{$inspection->location->code}}" readonly> --}}
            <select name="location_id" class="form-control select2 @error('location_id') is-invalid @enderror"
                id="location_id">
                @foreach ($locations as $r)
                    <option value="{{ $r->id }}" @if ($r->id == $inspection->location->id) selected @endif>
                        {{ $r->code }}</option>
                @endforeach
            </select>
            @error('location_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        @else
            <select name="location_id" class="form-control select2 @error('location_id') is-invalid @enderror"
                id="location_id">
                @foreach ($locations as $r)
                    <option value="{{ $r->id }}">{{ $r->code }}</option>
                @endforeach
            </select>
            @error('location_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        @endif
    </div>

    <div class="form-group mb-3">
        <label for="action_date">Tanggal & Waktu</label>
        <input name="action_date" type="datetime-local" class="form-control @error('action_date') is-invalid @enderror"
            id="action_date" value="{{ old('action_date') ?? (!isset($inspection) ? '' : $inspection->action_date) }}">
        @error('action_date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="ka_no">No. KA</label>
        <input name="ka_no" type="text" class="form-control @error('ka_no') is-invalid @enderror" id="ka_no"
            value="{{ old('ka_no') ?? (!isset($inspection) ? '' : $inspection->ka_no) }}">
        @error('ka_no')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
