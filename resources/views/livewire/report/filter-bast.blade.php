<div>
    <form action="">
        <!-- By Vendor -->
        <div class="row">
            <div class="col-sm-2">
                <h6>Vendor</h6>
            </div>
            <div class="col-sm-10">
                <div class="form-group">
                    <select wire:model="vendor" name="by_vendor" id="by_vendor" class="form-control">
                        <option value="">-- pilih --</option>
                        @foreach ($vendors as $v)
                            <option value="{{ $v->id }}">{{ $v->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- By Contract -->
        <div class="row">
            <div class="col-sm-2">
                <h6>No Kontrak</h6>
            </div>
            <div class="col-sm-10">
                <div class="form-group">
                    <select wire:model="contract" name="by_contract" id="by_contract" class="form-control">
                        <option value="">-- pilih --</option>
                        @if ($vendor != '')
                            @foreach (\App\Models\Vendor::find($vendor)->contracts()->get() as $c)
                                <option value="{{ $c->id }}">{{ $c->code }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>

        <!-- By Date Range -->
        <div class="row">
            <div class="col-sm-2">
                <h6>BAST dari Tgl s/d Tgl</h6>
            </div>
            <div class="col-sm-10 ">
                <div class="form-group">
                    <div class="input-group date">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Dari</span>
                        </div>
                        <input wire:model="startDate" type="date" id="startDate" class="form-control date_timepicker_end"
                            value="{{ isset($from) ? \Carbon\Carbon::parse($from)->format('d-m-Y') : '' }}"
                            name="from" max="{{ date('d-m-Y') }}">
                        <div class="input-group-append">
                            <span class="input-group-text">Sampai</span>
                        </div>
                        <input wire:model="endDate" id="endDate" type="date" class="form-control date_timepicker_end"
                            name="to" value="{{ isset($to) ? \Carbon\Carbon::parse($to)->format('d-m-Y') : '' }}"
                            max="{{ date('d-m-Y') }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="row py-2">
            <div class="col-sm-2">
                <h6>Tipe</h6>
            </div>
            <div class="col-sm-10">
                <div class="form-group">
                    <select wire:model="filterType" name="by_type" id="by_type" class="form-control">
                        <option value="">-- pilih --</option>
                        <option value="Maintenance" {{ $filterType == "Maintenance" ? 'selected' : null}}>Maintenance</option>
                        <option value="Upgrade & Repair" {{ $filterType == "Upgrade & Repair" ? 'selected' : null}}>Upgrade & Repair</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- By Location -->
        <div class="row">
            <div class="col-sm-2">
                <h6>Lokasi</h6>
            </div>
            <div class="col-sm-10">
                <div class="form-group">
                    <select wire:model="location" name="by_location" id="by_location" class="form-control">
                        <option value="">-- pilih --</option>
                        @foreach ($locations as $l)
                            <option value="{{ $l->id }}">{{ $l->code }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="d-flex">
                    <button class="flex-fill btn btn-success" name="action" value="filter">Process</button>
                    &nbsp;
                    <button class="flex-fill btn btn-primary" name="action" value="export">Export</button>
                    &nbsp;
                    <button class="flex-fill btn btn-warning" id="btnReset" >Reset</button>
                </div>
            </div>
        </div>
    </form>



    @push('scripts')
        <script>
            const btnReset = document.getElementById('btnReset');
            btnReset.addEventListener('click', function() {
                const byVendor = document.getElementById('by_vendor').value = '';
                const byContract = document.getElementById('by_contract').value = '';
                const byType = document.getElementById('by_type').value = '';
                const byLocation = document.getElementById('by_location').value = '';
                const startDate = document.getElementById('startDate').value = '';
                const endDate = document.getElementById('endDate').value = '';
            })
        </script>
        
    @endpush
</div>
