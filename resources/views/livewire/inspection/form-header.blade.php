<div>
    {{-- allert --}}
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <div class="form-group p-0 m-0 py-1">
        <label for=""><strong>Jenis perbaikan <span class="text-danger">*</span></strong></label>
        <select class="form-select form-select-sm" name="fixing_job_type" wire:model="fixing_job_type">
            <option value=""> -- Pilih kerusakan -- </option>
            <option value="Maintenance" @if($fixing_job_type == 'Maintenance') selected @endif>Maintenance</option>
            <option value="Upgrade & Repair" @if($fixing_job_type == 'Upgrade & Repair') selected @endif>Upgrade & Repair</option>
        </select>
    </div>
</div>
