<div>
    {{-- The best athlete wants his opponent at his best. --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="form-group mb-0">
                        <label for="">Filter Status</label>
                        <select name="" id="" class="form-control" wire:model="filterStatus">
                          <option value="">--- Pilih Status ---</option>
                           @foreach ($ctStatus as $key => $status)
                                @if($status == 'Maintenance')
                                <option value="{{$status}}">TSO (M)</option>
                                @elseif($status == 'Upgrade & Repair')
                                <option value="{{$status}}">TSO (U)</option>
                                @else
                                <option value="{{$status}}">{{$key}}</option>
                                @endif
                           @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-8 d-flex justify-content-end">
                    {{-- <div class="form-group mb-0 align-self-end">
                        <button wire:click="export" class="btn btn-primary">Export Ke Excel</button>
                    </div> --}}
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered border-primary" id="table-ct">
                    <thead>
                    <tr>
                        <th scope="col" colspan="10" class=" text-center bg-info text-white" >No Container</th>
                        <th scope="col" class="text-center bg-warning">Keterangan</th>
                    </tr>
                    </thead>
                    <tbody>
                        
        
                    @foreach ($containerVendors as $key => $ct)
                        @foreach ($ct->containers as $counter => $code)
                            @if($loop->iteration % 10 == 1)
                            <tr style=""> 
                            @endif
                                <td class="text-center align-item-center" id="code-{{$code->code}}" wire:click="showModal('{{$code->code}}')"

                                style="cursor: pointer; border: 2px solid black;
                                @if ($code->status->code == "TSO")
                                    @if($code->last_type_maintenance == 'Maintenance')
                                        background: {{$this->color['TSO_M']}};
                                    @elseif ($code->last_type_maintenance == 'Upgrade & Repair')
                                        background: {{$this->color['TSO_U']}};
                                        color: #ffffff;
                                    @else
                                        background: {{$this->color['TSO']}};
                                        color: #ffffff;
                                    @endif
                                @else
                                    background: {{$this->color[$code->status->code]}};
                                    /* color: #ffffff; */
                                @endif
                                " >{{ $code->code }}</td>

                                @if(count($ct->containers) < 10) 
                                    @if($loop->iteration == count($ct->containers))
                                        @for ($i = 0; $i < 10 - count($ct->containers); $i++)
                                            <td></td>
                                        @endfor
                                        <td class="text-center" rowspan="{{ceil($loop->count / 10)}}">
                                            Pembelian dari:
                                            <p class="bg-info text-white">{{$ct->name}}</p>
                                            <p>Total: {{$ct->total}}</p>
                                            <br>
                                            <p class="border" style="background: {{$this->color['SO']}};">SO: {{ $ct->container_status_so }}</p>
    
                                            <p class="border" style="background: {{$this->color['O']}};">O: {{ $ct->container_status_o }}</p>
                                            
                                            <p class="border" style="background:{{$this->color['TSO_M']}}">TSO (M): {{ $ct->container_status_tso_m }}</p>
    
                                            <p class="border text-white" style="background: {{$this->color['TSO_U']}}">TSO (U): {{ $ct->container_status_tso_u }}</p>
                                            
                                            <p class="border text-white" style="background: {{$this->color['S']}};">S: {{ $ct->container_status_s }}</p>   

                                            <p class="border text-white" style="background: {{$this->color['SOI']}};">SO (Isi): {{ $ct->container_status_soi }}</p>   

                                            <p class="border text-white" style="background: {{$this->color['TSOI']}};">TSO (Isi): {{ $ct->container_status_tsoi }}</p>                                   
                                        </td>
                                    @endif
                                @endif

                                                            

                                @if($loop->iteration == 10)
                                   
                                    <td class="text-center" rowspan="{{ceil($loop->count / 10)}}">
                                        Pembelian dari:
                                        <p class="bg-info text-white">{{$ct->name}}</p>
                                        <p>Total: {{$ct->total}}</p>
                                        <br>
                                        <p class="border" style="background: {{$this->color['SO']}};">SO: {{ $ct->container_status_so }}</p>

                                        <p class="border" style="background: {{$this->color['O']}};">O: {{ $ct->container_status_o }}</p>
                                        
                                        <p class="border" style="background:{{$this->color['TSO']}}">TSO: {{ $ct->container_status_tso }}</p>

                                        <p class="border" style="background:{{$this->color['TSO_M']}}">TSO (M): {{ $ct->container_status_tso_m }}</p>

                                        <p class="border text-white" style="background: {{$this->color['TSO_U']}}">TSO (U): {{ $ct->container_status_tso_u }}</p>
                                        
                                        <p class="border text-white" style="background: {{$this->color['S']}};">S: {{ $ct->container_status_s }}</p> 

                                        <p class="border text-white" style="background: {{$this->color['SOI']}};">SO (Isi): {{ $ct->container_status_soi }}</p>   

                                        <p class="border text-white" style="background: {{$this->color['TSOI']}};">TSO (Isi): {{ $ct->container_status_tsoi }}</p>                                    
                                    </td>
                                @endif

                            @if($loop->iteration % 10 == 0)                                                          
                            </tr>

                            @endif
            
                        @endforeach

                    @endforeach
                    
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="containerModal" tabindex="-1" aria-labelledby="containerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="containerModalLabel">Container Detail</h5>
            <button type="button" wire:click="closeModal" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                {{-- detail --}}
                <div class="row">
                    <div class="col-lg">
                        <div class="form-group mb-0 row">
                            <label for="">No Container</label>
                            <div class="col-sm-4 col-md-4">
                            <input type="text" class="form-control form-control-sm" wire:model="state.code" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg">
                        <div class="form-group mb-0">
                            <label for="">Tgl Pembelian</label>
                            <input type="text" class="form-control form-control-sm" wire:model="state.buy_date" readonly>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg">
                        <div class="form-group mb-0">
                            <label for="">Tgl Maintenance Terakhir</label>
                            <input type="text" class="form-control form-control-sm" wire:model="state.last_maintenance_date" readonly>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg">
                        <div class="form-group mb-0">
                            <label for="">Vendor Maintenance Terakhir</label>
                            <input type="text" class="form-control form-control-sm" wire:model="state.last_maintenance_vendor_id" readonly>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg">
                        <div class="form-group mb-0">
                            <label for="">Vendor Upgrade Terakhir</label>
                            <input type="text" class="form-control form-control-sm" wire:model="state.last_upgrade_vendor_id" readonly>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg">
                        <div class="form-group mb-0">
                            <label for="">Lokasi (SO/TSO)</label>
                            @if($isSO)
                            <input type="text" class="form-control form-control-sm" wire:model="state.up_location_id" readonly>
                            @elseif($isTSO)
                            <input type="text" class="form-control form-control-sm" wire:model="state.down_location_id" readonly>
                            @else
                            -
                            @endif
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group mb-0">
                            <label for="">Riwayat Maintenance / Upgrade </label>
                            
                            <table class="table">
                                <thead>
                                  <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Vendor</th>
                                    <th scope="col">Tanggal</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  @forelse ($state['bast_from_vendor'] as $record)
                                    @if(isset($record->delegationFromVendor))
                                        <tr>
                                            <th scope="row">{{ $record->delegationFromVendor->code ?? '-' }}</th>
                                            <td>{{ $record->delegationFromVendor->vendor->name ?? '-' }}</td>
                                            <td>{{ DateHelper::format($record->delegationFromVendor->action_date) ?? '-' }}</td>
                                        </tr>
                                    @endif
                                  @empty
                                      
                                  @endforelse
                                  
                              </table>
                            
                        </div>
                      
                    </div>
                </div>



            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="closeModal">Close</button>
            </div>
        </div>
        </div>
    </div>
  

    
</div>

@push('scripts')

    <script>
        window.addEventListener('show-modal', event => {
            $('#containerModal').modal('show');
        })

        window.addEventListener('close-modal', event => {
            $('#containerModal').modal('hide');
        })
    </script>

    
@endpush

