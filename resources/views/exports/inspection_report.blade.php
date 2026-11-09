<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>No CT</th>
            <th>Tgl Inspeksi</th>
            <th>Deskripsi</th>
            <th>Root Cause</th>
            <th>Kode Inspeksi</th>
        </tr>
    </thead>
    <tbody>
        @php
            $lastCt = '';
        @endphp
        @forelse ($results as $result)
            <tr>
                <td>{{ $result->container_code }}</td>
                <td>{{ DateHelper::format($result->action_date) ?? '-' }}</td>
                <td>{{ $result->damage_description ?? '-' }}</td>
                <td>{{ $result->root_cause }}</td>
                <td>{{ $result->code }}</td>
            </tr>
            @php
                $lastCt = $result->container_code;
            @endphp
        @empty
            <tr>
                <td colspan="13">Tidak ada data untuk informasi ini</td>
            </tr>
        @endforelse
    </tbody>
</table>
