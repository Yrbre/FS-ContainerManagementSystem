<div>
    {{-- allert --}}
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>   
    @endif
    @if ($root_cause)
        <select class="form-select form-select-sm" name="causeValue" wire:model="causeValue">
            <option value="{{$root_cause}}">{{$root_cause}}</option>
            {{-- filter rootCauseList list without root_cause --}}
            @foreach ($rootCauseList as $root)
                @if ($root != $root_cause)
                    <option value="{{$root}}">{{$root}}</option>
                @endif
            @endforeach
        </select>
    @else
        <select class="form-select form-select-sm" name="causeValue" wire:model="causeValue">
            <option value=""> -- Pilih kerusakan -- </option>
            @foreach ($rootCauseList as $root)
                <option value="{{$root}}">{{$root}}</option>
            @endforeach
        </select>
    @endif
</div>
