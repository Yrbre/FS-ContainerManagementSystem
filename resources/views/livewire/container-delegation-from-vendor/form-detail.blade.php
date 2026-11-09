<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="delegationModalLabel">Tambah Kontainer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        @include('partials.alert')

        <div class="form-group">
            <label class="font-weight-bold">Pilih Kontainer</label>
            <select  class="form-control select2-custom @error('selected_container') is-invalid @enderror" wire:model="selected_container">
                <option value="">-- pilih container --</option>
                @if ($containers)    
                    @foreach ($containers as $c)
                        <option value="{{ $c->code }}" {{ $selected_container == $c->code ? 'selected' : null }}>
                            {{ $c->code }}</option>
                    @endforeach
                @endif
            </select>
            @error('selected_container')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="font-weight-bold m-0">Foto Setelah Perbaikan</label>
            <input class="form-control @error('images.*') is-invalid @enderror" wire:model="images" type="file" multiple />
            @error('images.*')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror

            <div class="form-group">
                <div wire:loading wire:target="images">Mohon tunggu gambar sedang di upload...</div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" wire:loading.attr="disabled" wire:target="images" wire:click.prevent="submit" class="btn btn-primary">Save</button>
    </div>
</div>

@push('scripts')
    <script>
        $(function() {
            $('.select2-custom2').select2({
                theme: "bootstrap",
                dropdownParent: $('#delegationModal')
            });

            $('.select2-custom2').on('change', function(e) {
                @this.set('selected_container', e.target.value);
            });
        });
    </script>
@endpush
