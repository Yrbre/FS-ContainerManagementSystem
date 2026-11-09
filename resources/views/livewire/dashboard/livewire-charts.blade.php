{{-- <style>
    .apexcharts-xaxis {
        display: none !important;
    }
</style> --}}
<div class="container mx-auto space-y-4 p-4 sm:p-0">
    <ul class="flex flex-col sm:flex-row sm:space-x-8 sm:items-center">
        @foreach ($vendor as $vd)
            <li>
                <input type="checkbox" value="{{ $vd }}" wire:model="types" />
                <span>{{ $vd }}</span>
            </li>
        @endforeach
    </ul>
    <div style="height: 32rem;" class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
        <div class="shadow rounded border bg-white flex-1" style="height: 32rem;">
            <livewire:livewire-column-chart key="{{ $columnChartModel->reactiveKey() }}" :column-chart-model="$columnChartModel" />
        </div>
    </div>
</div>
