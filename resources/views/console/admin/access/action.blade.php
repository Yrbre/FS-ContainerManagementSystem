<div>
    <div class="d-flex justify-content-center">
        <a href="{{ route('console.access.edit', $id) }}" class="btn btn-warning btn-sm d-flex align-items-center me-2">
            <i class="fa fa-pencil-alt"></i> <span class="ms-1">Edit</span>
        </a>
        <form method="post" class="@if (auth()->id() == $id) d-none @else d-inline @endif" onsubmit="return confirm('Are you sure?')" action="{{ route('console.access.destroy', $id) }}">
            @csrf
            @method('DELETE')
            
            <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center">
                <i class="fas fa-trash"></i> <span class="ms-1">Delete</span>
            </button>
        </form>
    </div>
</div> 