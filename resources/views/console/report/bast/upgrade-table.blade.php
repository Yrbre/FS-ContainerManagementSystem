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
            $lastCt = '';
        @endphp
        @forelse ($results as $result)
            <tr>
                @if ($lastCt != $result->container_code)
                    @php
                        // $rowspan = count($results->groupBy('container_code')[$result->container_code]);
                        $rowspan = $results
                            ->where('container_code', $result->container_code)
                            ->where('action_date', $result->action_date)
                            ->count();
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
                $lastCt = $result->container_code;
            @endphp
        @empty
            <tr>
                <td colspan="7">Tidak ada data untuk informasi Upgrade & Repair ini</td>
            </tr>
        @endforelse
    </tbody>
</table>
