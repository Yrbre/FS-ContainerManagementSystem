<div>
    <button class="btn btn-sm btn-warning" wire:click="editSubDetail({{ $subDetailId }})">Edit</button>

    <!-- Modal Edit -->
    @if ($openEditSubDetailModal == true)    
        <div class="modal show fade d-block" id="delegationSubDetailEditModal">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="delegationSubDetailModalLabel">Edit Sub Detail</h5>
                            <button type="button" class="close"  wire:click="closeEditSubDetailModal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @include('partials.alert')
                        
                            @can(['Supervisor'])
                                <div class="form-group">
                                    <label class="font-weight-bold m-0">Root Cause</label>
                                    <select class="form-control @error('causeValue') is-invalid @enderror" wire:model="causeValue">
                                        <option value="{{ $root_cause }}">{{ $root_cause }}</option>
                                        @foreach ($rootCauseList as $root)
                                            @if ($root != $root_cause)
                                                <option value="{{$root}}">{{$root}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    
                                    @error('causeValue')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror    
                                </div>
                            @endcan      
                                
                            <div class="form-group">
                                <label class="font-weight-bold m-0">Deskripsi Kerusakan</label>
                                <textarea class="form-control @error('damage_description') is-invalid @enderror" wire:model="damage_description"></textarea>
                                @error('damage_description')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                    
                            <div class="form-group">
                                <label class="font-weight-bold m-0">Jenis Perbaikan</label>
                                <select wire:model="contract_detail_id" class="form-control @error('contract_detail_id') is-invalid @enderror">
                                    <option value="">-- Pilih Jenis Perbaikan --</option>
                                    @if ($contractDetail)    
                                        @foreach ($contractDetail as $type)
                                            <option value="{{ $type->id }}">{{ $type->job_type }}</option>
                                        @endforeach
                                    @endif
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                                @error('contract_detail_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            @if ($contract_detail_id == 'Lainnya')
                            <div class="form-group">
                                <label class="font-weight-bold m-0">Ketik Jenis Perbaikan</label>
                                <input type="text" wire:model.lazy="jobTypeOther" class="form-control @error('jobTypeOther') is-invalid @enderror">
                                @error('jobTypeOther')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            @endif  
                    
                            <div class="form-group">
                                <label class="font-weight-bold m-0">Ukuran Material</label>
                                <input type="text" class="form-control @error('material_size') is-invalid @enderror" wire:model="material_size" placeholder="ex: 30x100">
                                @error('material_size')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                    
                            <div class="form-group">
                                <label class="font-weight-bold m-0">Keterangan</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" wire:model="description"></textarea>
                                @error('description')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                    
                            <div class="form-group">
                                <label class="font-weight-bold m-0">Kuantitas</label>
                                <input type="number" class="form-control @error('qty') is-invalid @enderror" wire:model="qty">
                                @error('qty')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                    
                            <div class="form-group">
                                <label class="font-weight-bold m-0">Satuan</label>
                                <input class="form-control @error('unit') is-invalid @enderror" wire:model="unit"  @if ($contract_detail_id != 'Lainnya') readonly @endif>
                                @error('unit')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                    
                            <div class="form-group">
                                <label class="font-weight-bold m-0">Harga Satuan</label>
                                <input type="number" class="form-control @error('unit_price') is-invalid @enderror" wire:model="unit_price">
                                @error('unit_price')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold m-0">Estimasi Harga</label>
                                <input type="number" class="form-control @error('price_estimation') is-invalid @enderror" wire:model="price_estimation" readonly>
                                @error('price_estimation')
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
                            <button type="button" class="btn btn-secondary" wire:click="closeEditSubDetailModal">Close</button>
                            <button wire:loading.attr="disabled" wire:target="images" wire:click.prevent="updateSubDetailData" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>            
            </div>
        </div>

        <div class="modal-backdrop show fade"></div>
    @endif
    <!-- End Modal Edit -->
</div>