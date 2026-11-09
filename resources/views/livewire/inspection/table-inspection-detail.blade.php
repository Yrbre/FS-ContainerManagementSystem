<div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Kontainer</th>
                <th>Detail kerusakan</th>
                <th>Penyebab Kerusakan</th>
                <th>Root Cause</th>
                <th>Tgl ditambah</th>
                <th>Gambar</th>
                <th>Garansi</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($inspectionList as $key => $row)
                <tr wire:key="item-{{ $key }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $row->container_code }}</td>
                    <td>{{ $row->damage_description }}</td>
                    <td>{{ $row->damage_cause_description }}</td>
                    <td>
                        @can(['Supervisor', 'Administrator'])
                        <livewire:inspection.form-root-cause wire:key="root-cause-{{ $key }}" :rootCause="$rootCauseList" :detailsId="$row->id" :root_cause="$row->root_cause" />
                        @elsecan('Checker')
                            {{ $row->root_cause ?? '-' }}
                        @endcan
                    </td>
                    <td>{{ $row->created_at->format('d-m-Y H:i:s') }}</td>
                    <td>
                        @foreach ($row->images as $img )
                            <a target="_blank" href="{{ Storage::url($img) }}">Tampilkan</a>
                        @endforeach
                    </td>
                    <td>
                        <livewire:container.warranty-modal wire:key="waranty-modal-item-{{ $key }}" ct="{{ $row->container_code }}"/>
                    </td>
                    <td class="">
                        @can(['Checker'])
                            @if($inspection->status == "DRAFT")
                                
                                <form action="{{ route('console.inspection.detail.destroy', $row->id) }}" method="post" class="d-flex flex-row">
                                    @csrf
                                    @method('delete')

                                    <livewire:inspection.form-edit-modal wire:key="edit-form-{{ $key }}" detailId="{{ $row->id }}" />

                                    <button type="submit" class="btn btn-danger mx-1" onclick="return confirm('Yakin mau dihapus?')">Delete</button>
                                </form>
                            @endif
                        @endcan
                    </td>
                </tr>
            @empty
                
            @endforelse
        </tbody>
    </table>
</div>
