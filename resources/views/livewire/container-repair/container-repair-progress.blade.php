<div>    
    <div class="card-body">   
        <div>
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
        </div>

         <!-- Modal -->
            <div class="modal fade" wire:ignore.self id="updatesModal" tabindex="-1 " aria-labelledby="updatesModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="updatesModalLabel">Update Progress Serentak</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <div>
                            @if (session()->has('message_modal'))
                                <div class="alert alert-success">
                                    {{ session('message_modal') }}
                                </div>
                            @endif
                        </div>
                
                        <div class="form-group">
                            <label for="">Progress (%)</label>
                            <input type="text" class="form-control" name="inputProgressed" wire:model="inputProgressed">
                        </div>

                        <div class="form-group">
                            <label for="">Deskripsi</label>
                            <textarea name="inputDescriptions" wire:model="inputDescriptions" class="form-control" id="" cols="30" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click.prevent="submitProgressed">Update Serentak</button>
                    </div>
                </div>
                </div>
            </div>

        @if($containerRepair->status == "DRAFT")
            <button type="button" class="btn btn-primary mb-3" @if (!$detailIds) disabled @else data-toggle="modal" data-target="#updatesModal" @endif>
                    Update Progress Serentak
            </button>
        @endif
            
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Kontainer</th>
                        <th>Progress (%)</th>
                        <th>Keterangan Perbaikan</th>
                        <th>Tgl. Diubah</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($containerRepair->details()->orderBy('created_at', 'desc')->get() as $key => $row)
                        <tr>
                            <td>
                            @can(['Checker'])

                                <div class="form-check">
                                    @if($containerRepair->status == "DRAFT")
                                        <input class="form-check-input @error('detailIds') is-invalid @enderror" type="checkbox" value="{{$row->id}}" wire:model="detailIds" >
                                    @endif
                                    @error('detailIds')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <label class="form-check-label" for="flexCheckDefault">
                                        {{ $loop->iteration }}
                                    </label>
                                  </div>
                            @elsecan(['Supervisor'])
                                {{ $loop->iteration }}
                            @endcan
                            
                                </td>
                            <td>{{ $row->container_code }}</td>
                            <td>

                                @if(in_array($row->id, $detailIds))
                                    <input type="number" class="form-control @error('progress.'.$row->id) is-invalid @enderror" wire:model="progress.{{ $row->id }}" min="0" max="100" placeholder=">= {{$row->progress}}">
                                    @error('progress.'.$row->id)
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                @else
                                    {{ $row->progress }} %
                                @endif
 

                            </td>
                            <td>
                                @if(in_array($row->id, $detailIds))
                                    <input class="form-control @error('description.'.$row->id) is-invalid @enderror" wire:model="description.{{ $row->id }}">
                                    @error('description.'.$row->id)
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                @else
                                {{ $row->description }}                                    
                                @endif
                            </td>
                            <td>{{ $row->updated_at->format('d-m-Y H:i:s') }}</td>
                        </tr>
                    @empty  
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @can(['Checker'])
        
    <div class="card-footer d-flex justify-content-end">
        @if($containerRepair->status == "DRAFT")
        <button class="btn btn-primary" 
            @if(empty($detailIds))
            disabled 
            @endif
 wire:click.prevent="submit">Save</button>
        @endif
    </div>
    @endcan

</div>

@push('script')

    



@endpush
