<div>
    <form method="post" class="d-flex flex-column justify-content-center text-center"  onsubmit="return confirm('Yakin mau menghapus data ini?')" action="{{ route('console.contract.detail.destroy', $id) }}">

        <a href="{{ route('console.contract.detail.edit', $id) }}" class="badge badge-sm badge-warning me-5 mt-1 d-flex align-self-start" style="text-decoration: none">
            <i class="fa fa-pencil-alt"></i> <span class="ms-1">Edit</span>
        </a>
           
        @csrf
        @method('DELETE')    
        <button type="submit" class="badge badge-sm badge-danger d-flex align-self-start  me-5 mt-1" style="border:none">
            <i class="fas fa-trash"></i> <span class="ms-1">Delete</span>
        </button>
    </form>
</div> 