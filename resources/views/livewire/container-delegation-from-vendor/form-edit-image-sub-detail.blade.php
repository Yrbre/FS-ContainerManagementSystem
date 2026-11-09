<div>
    <button class="btn btn-sm btn-warning d-flex align-items-center" type="button" wire:click="openModalEditImage">
        <i class="fa fa-pencil-alt mr-1"></i> Gambar
    </button>

    {{-- Start Modal --}}
    @if ($openModalEditImage == true)    
        <div class="modal show fade d-block" id="EditImageSubDetailModal">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="EditImageSubDetailModalLabel">Update Gambar Sub Detail BAST</h5>
                        <button type="button" class="close" wire:click="closeModalEditImage">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="font-weight-bold m-0">Foto Setelah Perbaikan</label>
                            <input class="form-control @error('images.*') is-invalid @enderror" wire:model="images" type="file" multiple/>
                            @error('images.*')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div wire:loading wire:target="images">Mohon tunggu gambar sedang di upload...</div>
                        </div>
                    </div>
                
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModalEditImage">Close</button>
                        <div wire:loading.remove>
                            <button type="button" wire:click="saveImage" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-backdrop show fade"></div>
    @endif
</div>
