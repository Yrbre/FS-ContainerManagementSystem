<div>
    <div class="d-flex justify-content-center">
        <a href="{{ route('console.delegation-to-vendor.detail', $id) }}" class="btn btn-info btn-sm d-flex align-items-center me-2">
            <i class="fa fa-eye"></i> <span class="ms-1">Detail</span>
        </a>
        @if ($status == 'DRAFT')    
            @can(['Checker', 'Supervisor'])
                <a href="{{ route('console.delegation-to-vendor.edit', $id) }}" class="btn btn-warning btn-sm d-flex align-items-center me-2">
                    <i class="fa fa-pencil-alt"></i> <span class="ms-1">Edit</span>
                </a>
            @endcan

            @can(['Checker'])
                <form method="post" class="d-inline" onsubmit="return confirm('Yakin mau menghapus data ini?')" action="{{ route('console.delegation-to-vendor.destroy', $id) }}">
                    @csrf
                    @method('DELETE')
                    
                    <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center">
                        <i class="fas fa-trash"></i> <span class="ms-1">Delete</span>
                    </button>
                </form>
            @endcan
        @endif
    </div>
</div> 