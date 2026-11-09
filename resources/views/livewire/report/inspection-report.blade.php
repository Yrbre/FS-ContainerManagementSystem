<div>
    <form action="">
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

        <!-- By Date Range -->
        <div class="row">
            <div class="col-sm-2">
                <h6>Inspeksi dari Tgl s/d Tgl</h6>
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
                const byType = document.getElementById('by_type').value = '';
                const byLocation = document.getElementById('by_location').value = '';
                const startDate = document.getElementById('startDate').value = '';
                const endDate = document.getElementById('endDate').value = '';
            })
        </script>
        
    @endpush
</div>
