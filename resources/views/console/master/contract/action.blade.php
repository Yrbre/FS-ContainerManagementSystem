<div>
    <div class="d-flex justify-content-center">
        @can(['Supervisor'])
            <a href="{{ route('console.contract.edit', $id) }}" class="btn btn-warning btn-sm d-flex align-items-center me-2">
                <i class="fa fa-pencil-alt"> </i><span class="ms-1">Edit</span>
            </a>
        @endcan

        <a href="{{ route('console.contract.detail.index', $id) }}" class="btn btn-info btn-sm d-flex align-items-center me-2">
        <i class="fa fa-eye"></i> <span class="ms-1">Show</span>
        </a>

        @can(['Supervisor'])
            <form method="post" class="d-inline" onsubmit="return confirm('Yakin mau menghapus data ini?')" action="{{ route('console.contract.destroy', $id) }}">
                @csrf
                @method('DELETE')
                
                <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center">
                    <i class="fas fa-trash"></i> <span class="ms-1">Delete</span>
                </button>
            </form>
        @endcan
    </div>
</div> 