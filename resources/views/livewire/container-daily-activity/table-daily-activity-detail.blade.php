<div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Kontainer</th>
                <th>Tipe</th>
                <th>Nomor Gerbong Datar</th>
                <th>Asal Kontainer</th>
                <th>No. TS Tujuan</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($containerDailyActivity->details()->orderBy('container_code', 'asc')->get() as $key => $row)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $row->container_code }}</td>
                    <td>{{ $row->type }}</td>
                    <td>{{ $row->carriage_number }}</td>
                    <td>{{ $row->container_source }}</td>
                    <td>{{ $row->trainset_number }}</td>
                    <td>
                        {{-- delete button --}}
                        @can(['Checker', 'Administrator'])
                            @if ($containerDailyActivity->status == 'DRAFT')
                                <button type="button" class="btn btn-danger btn-sm" wire:click="delete({{ $row->id }})" onclick="return confirm('Yakin mau dihapus?') || event.stopImmediatePropagation()">Delete</button>
                            @endif
                        @endcan
                    </td>
                </tr>
            @empty
                
            @endforelse
        </tbody>
    </table>
</div>
