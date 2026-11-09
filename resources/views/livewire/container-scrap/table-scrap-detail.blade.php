<div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Kode Kontainer</th>
                <th>Persentase Kerusakan</th>
                <th>Description</th>
                <th>Foto</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($containerScrap->details()->orderBy('container_code', 'asc')->get() as $key => $row)
                <tr>
                    <td>{{ $row->container_code }}</td>
                    <td>{{ $row->persentase }}</td>
                    <td>{{ $row->description }}</td>
                    <td>
                        @foreach ($row->images as $img)
                            <a href="{{ Storage::url($img) }}" target="_blank">Tampilkan</a>
                        @endforeach
                    </td>
                    <td>
                        @can(['Supervisor', 'Administrator'])
                            <form action="{{ route('console.container-scrap.detail.destroy', [$containerScrap, $row->id]) }}"
                                method="post">
                                @csrf
                                @method('DELETE')
                                @if ($containerScrap->status == 'DRAFT')
                                    <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Detail scrap akan dihapus, apakah anda yakin?') || event.stopImmediatePropagation()">Delete</button>
                                @endif
                            </form>
                        @endcan
                    </td>
                </tr>
            @empty
            @endforelse
        </tbody>
    </table>
</div>
