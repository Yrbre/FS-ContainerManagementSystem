<div>
    <div class="d-flex justify-content-center">
        @can(['Supervisor'])
            <a href="{{ route('console.container.edit', $code) }}" class="btn btn-warning btn-sm d-flex align-items-center me-2">
                <i class="fa fa-pencil-alt"></i> <span class="ms-1">Edit</span>
            </a>
        @endcan

        <a href="{{ route('console.container.show', $code) }}" class="btn btn-info btn-sm d-flex align-items-center me-2">
            <i class="fa fa-eye"></i> <span class="ms-1">Show</span>
        </a>

        @can(['Supervisor'])
            <form method="post" class="d-inline" onsubmit="return confirm('Yakin mau menghapus data ini?')" action="{{ route('console.container.destroy', $code) }}">
                @csrf
                @method('DELETE')
                
                <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center">
                    <i class="fas fa-trash"></i> <span class="ms-1">Delete</span>
                </button>
            </form>
        @endcan
    </div>
</div> 