<div>
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#editModal-{{ $detailId }}">
        Edit
    </button>
        
      <!-- Modal -->
    <div class="modal fade moda-due" wire:ignore id="editModal-{{ $detailId }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Edit Modal</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
                <label class="font-weight-bold">Pilih Kontainer</label>
                <select class="form-control select2-custom  @error('selected_container') is-invalid @enderror" wire:model="selected_container" >
                    <option value="">-- pilih container --</option>
                    @foreach ($containers as $c)
                    <option value="{{ $c->code }}" {{ $selected_container == $c->code ? 'selected' : null }}>
                        {{ $c->code }}</option>
                @endforeach
                    
                </select>
                @error('selected_container')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

                @php
                    $c = \App\Models\Container::find($selected_container);
                @endphp
    
                <div class="form-group">
                    <label class="font-weight-bold m-0">Tanggal Pengadaan</label>
                    <input class="form-control-plaintext" value="{{ \Carbon\Carbon::parse($c->buy_date)->format('d-m-Y') }}">
                </div>
                <div class="form-group">
                    <label class="font-weight-bold m-0">Tanggal Maintenance / Upgrade Terakhir</label>
                    <input class="form-control-plaintext" value="{{ \Carbon\Carbon::parse($c->last_upgrade_date)->format('d-m-Y') ?? '-' }}">
                </div>
                <div class="form-group">
                    <label class="font-weight-bold m-0">Masih Garansi s/d</label>
                    <input class="form-control-plaintext" value="{{ $c->warranty_date ?? '-' }}">
                </div>
                <div class="form-group">
                    <label class="font-weight-bold m-0">Vendor Garansi</label>
                    <input class="form-control-plaintext" value="{{ $c->contract->vendor->name ?? '-' }}">
                </div>
                <div class="form-group">
                    <label class="font-weight-bold m-0">Detail Kerusakan</label>
                    <textarea class="form-control @error('damage_description') is-invalid @enderror" wire:model="damage_description"></textarea>
                    @error('damage_description')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="font-weight-bold m-0">Penyebab Kerusakan</label>
                    <textarea class="form-control @error('damage_cause_description') is-invalid @enderror" wire:model="damage_cause_description"></textarea>
                    @error('damage_cause_description')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="font-weight-bold m-0">Foto Kerusakan</label>
                    <input class="form-control @error('images.*') is-invalid @enderror" wire:model="images" type="file" multiple/>
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
      </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $.fn.modal.Constructor.prototype.enforceFocus = function () { };
                const id = {{ $detailId }};

                console.log('#editModal-' + id);

                $('.select2-custom').select2(
                    {
                        theme: 'bootstrap',
                        dropdownParent: $('#editModal-' + id)

                    }
                );

                $('.select2-custom').on('change', function(e) {
                    @this.set('selected_container', e.target.value);
                });
            });
        </script>
        
    @endpush




</div>

