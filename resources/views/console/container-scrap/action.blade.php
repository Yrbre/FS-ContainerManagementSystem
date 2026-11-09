<div>
    <div class="d-flex justify-content-center">
        <a href="{{ route('console.container-scrap.detail', $id) }}" class="btn btn-info btn-sm d-flex align-items-center me-2">
            <i class="fa fa-eye"></i> <span class="ms-1">Detail</span>
        </a>
        @can(['Supervisor'])            
            @if ($status == 'DRAFT')
                {{-- Di comment dlu, karena kalo di edit data nya jadi ngaco --}}
                <a href="{{ route('console.container-scrap.edit', $id) }}" class="btn btn-warning btn-sm d-flex align-items-center me-2">
                    <i class="fa fa-pencil-alt"></i> <span class="ms-1">Edit</span>
                </a>
                
                <form method="post" class="d-inline" onsubmit="return confirm('Yakin mau menghapus data ini?')" action="{{ route('console.container-scrap.destroy', $id) }}">
                    @csrf
                    @method('DELETE')
                    
                    <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center">
                        <i class="fas fa-trash"></i> <span class="ms-1">Delete</span>
                    </button>
                </form>
            @endif
        @endcan
    </div>
</div> 