<table class="table table-responsive-lg">
    <thead>
        <tr>
          <th scope="col">No CT</th>
          <th scope="col">Company</th>
          <th scope="col">Tgl Pembelian</th>
          <th scope="col">Garansi s/d</th>
          <th scope="col">Vendor Garansi</th>
          <th scope="col">Status</th>
          <th scope="col">Lokasi</th>
          <th scope="col">Tgl Inpeksi</th>
          <th scope="col">Tgl Bast Ke Vendor</th>
          <th scope="col">Vendor Maintenance/Upgrade</th>
          <th scope="col">Progress (%)</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($containers as $ct)

            <tr>
                <td>
                    {{ $ct->code }}
                </td>
                <td>{{$ct->company->name}}</td>
                <td>{{ DateHelper::format($ct->buy_date) ?? '-' }}</td>
                <td>{{ $ct->warranty_date_start 
                        ? \Carbon\Carbon::parse($ct->warranty_date_start)->format('d-m-Y') .   ' s/d '  .  \Carbon\Carbon::parse($ct->warranty_date_end)->format('d-m-Y')
                        : '-'
                     }} </td>
                <td>{{$ct->vendor->name}}</td>
                <td>
                    @if($ct->status->code == 'TSO')
                        @if($ct->last_type_maintenance == 'Maintenance')
                            TSO (M)
                        @elseif($ct->last_type_maintenance == 'Upgrade & Repair')
                            TSO (U)
                        @else
                            TSO 
                        @endif 
                    @else
                        {{$ct->status->code}}
                    @endif
                </td>
                <td>
                   @if(isset($ct->status))
                        @if($ct->status->code == 'SO') 
                            {{$ct->upLocation->code ?? '-'}}
                        @elseif($ct->status->code == 'TSO')
                            {{$ct->downLocation->code ?? '-'}}
                        @endif
                   @else
                        -
                   @endif
                    
                </td>
                <td> 
                    {{ isset($ct->inspectionDetail)
                        ? \Carbon\Carbon::parse($ct->inspectionDetail->created_at)->format('d-m-Y')
                        : '-' }} 
                </td>
                <td>{{ isset($ct->bastToVendor)
                    ? \Carbon\Carbon::parse($ct->bastToVendor->created_at)->format('d-m-Y')
                    : '-' }} </td>
                <td>
                    @if($ct->last_type_maintenance == 'Maintenance' && $ct->status->code == "TSO" || $ct->status->code == "SO")
                    {{$ct->lastMaintenanceVendor->name}}
                    @elseif($ct->last_type_maintenance == 'Upgrade & Repair' && $ct->status->code == "TSO" || $ct->status->code == "SO")
                    {{$ct->lastUpgradeVendor->name}}
                    @else
                        -
                    @endif 

                </td>
               <td>{{ $ct->repairDetail->progress ?? '0' }} %</td>                      
            </tr>
        
        @empty
            <tr>
                <td colspan="11">Opps! Data tidak di temukan.</td>
            </tr>
        @endforelse

      </tbody>
    
</table>