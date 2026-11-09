<table class="table table-bordered border-primary" style="background-color: red;">
    <thead>
    <tr>
        <th scope="col" colspan="10" class="text-center bg-info text-white">No Container</th>
        <th scope="col" class="text-center bg-warning">Keterangan</th>
    </tr>
    </thead>
    <tbody>
        
 
    @foreach ($containerVendors as $key => $ct)
        @foreach ($ct->containers as $counter => $code)
            @if($loop->iteration % 10 == 1)
            <tr> 
            @endif
                <td class="text-center align-item-center"

                style="
                @if($code->last_type_maintenance == 'Maintenance')
                background: {{$color['TSO_M']}};

                @elseif($code->last_type_maintenance == 'Upgrade & Repair')
                background: {{$color['TSO_U']}};
                color: #ffffff;

                @elseif($code->status->code == $color['S'])
                background: {{$color['S']}};
                color: #ffffff;


                @elseif($code->status->code == $color['O'])
                background: {{$color['O']}};

                @elseif($code->status->code == $color['SO'])
                background: {{$color['SO']}};
                @endif
                " > 
    
                    @if($code->code < 10)
                        00{{ $code->code }}
                    @elseif(substr($code->code, 0, 2) == '00')
                        {{ $code->code }}
                    @elseif ($code->code < 100)
                        0{{ $code->code }}
                    @elseif(substr($code->code, 0, 1) == '0')
                        {{ $code->code }}
                    @else
                        {{ $code->code }}
                    @endif
                    
                </td>

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
                            <p class="border" style="background: {{$color['SO']}};">SO: {{ $ct->container_status_so }}</p>

                            <p class="border" style="background: {{$color['O']}};">O: {{ $ct->container_status_o }}</p>
                            
                            <p class="border" style="background:{{$color['TSO_M']}}">TSO (M): {{ $ct->container_status_tso_m }}</p>

                            <p class="border text-white" style="background: {{$color['TSO_U']}}">TSO (U): {{ $ct->container_status_tso_u }}</p>
                            
                            <p class="border text-white" style="background: {{$color['S']}};">S: {{ $ct->container_status_s }}</p>                                   
                        </td>
                    @endif
                @endif



                @if($loop->iteration == 10)
                    
                    <td class="text-center" rowspan="{{ceil($loop->count / 10)}}">
                        Pembelian dari:
                        <p class="bg-info text-white">{{$ct->name}}</p>
                        <p>Total: {{$ct->total}}</p>
                        <br>
                        <p class="border" style="background: {{$color['SO']}};">SO: {{ $ct->container_status_so }}</p>

                        <p class="border" style="background: {{$color['O']}};">O: {{ $ct->container_status_o }}</p>
                        <p class="border" style="background:{{$color['TSO_M']}}">TSO (M): {{ $ct->container_status_tso_m }}</p>
                        <p class="border text-white" style="background: {{$color['TSO_U']}}">TSO (U): {{ $ct->container_status_tso_u }}</p>
                        
                        <p class="border text-white" style="background: {{$color['S']}};">S: {{ $ct->container_status_s }}</p>                                   
                    </td>
                @endif

            @if($loop->iteration % 10 == 0)                                                          
            </tr>
            @endif

        @endforeach                          
        
    @endforeach
    
    </tbody>
</table>