<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>No CT</th>
            <th>No GD Asal</th>
            <th>Tgl BAST ke Vendor</th>
            <th>Tgl Selesai</th>
            <th>Pekerjaan Upgrade</th>
            <th>Keterangan Tambahan</th>
            <th>Qty</th>
        </tr>
    </thead>
    <tbody>
        @php
            // Grouping per BAST (id_detail), bukan per container_code,
            // agar kontainer yang sama di BAST/lokasi berbeda tampil sebagai grup terpisah
            $lastGroup = false;
        @endphp
        @forelse ($results as $result)
            @php
                // id_detail bisa NULL (BAST belum kembali dari vendor, hasil LEFT JOIN) -> tiap baris jadi grup sendiri
                $isNewGroup = is_null($result->id_detail) || $lastGroup !== $result->id_detail;
            @endphp
            <tr>
                @if ($isNewGroup)
                    @php
                        // $rowspan = count($results->groupBy('container_code')[$result->container_code]);
                        $rowspan = is_null($result->id_detail) ? 1 : $results->where('id_detail', $result->id_detail)->count();
                    @endphp
                    <td rowspan="{{ $rowspan }}">{{ $result->container_code }}</td>
                    <td rowspan="{{ $rowspan }}">{{ $result->carriage_number ?? '-' }}</td>
                    <td rowspan="{{ $rowspan }}">
                        {{ $result->action_date ? DateHelper::format($result->action_date) : '-' }}
                    </td>
                    <td rowspan="{{ $rowspan }}">{{ DateHelper::format($result->tgl_selesai) ?? '-' }}
                    </td>
                @else
                @endif
                <td>{{ $result->job_type }}</td>
                <td>{{ $result->root_cause ?? '-' }}</td>
                <td>{{ $result->qty }}</td>

            </tr>
            @php
                $lastGroup = $result->id_detail;
            @endphp
        @empty
            <tr>
                <td colspan="7">Tidak ada data untuk informasi Upgrade & Repair ini</td>
            </tr>
        @endforelse
    </tbody>
</table>
