@if ($status == 'CONNECTED')
    <a href="{{ route('console.config.terminate') }}" class="btn btn-danger btn-sm d-flex align-items-center me-2"
        onclick="return confirm('Are you sure you want to terminate?')">
        <i class="fa fa-pause"></i> <span class="ms-1">Terminate</span>
    </a>
@else
    <a href="{{ route('console.config.start') }}" class="btn btn-success btn-sm d-flex align-items-center me-2"
        onclick="return confirm('Are you sure you want to start?')">
        <i class="fa fa-play"></i> <span class="ms-1">Start</span>
    </a>
@endif


<livewire:w-a-service.q-r-code-modal />
