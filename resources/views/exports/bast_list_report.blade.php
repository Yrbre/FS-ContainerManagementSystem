<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>No CT</th>
            <th>Tgl BAST ke Vendor</th>
            <th>Tgl Selesai</th>
            <th>Jenis Perbaikan</th>
            <th>Penyebab Kerusakan</th>
            <th>Ukuran Material</th>
            <th>Qty</th>
            <th>Satuan</th>
            <th>Harga</th>
            <th>Total</th>
            <th>Approved by CTC Spv</th>
            <th>Approved by Shipping Mgr</th>
            <th>Approved by FA Director</th>
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
                    <td rowspan="{{ $rowspan }}">{{ DateHelper::format($result->action_date) }}</td>
                    <td rowspan="{{ $rowspan }}">{{ DateHelper::format($result->tgl_selesai) ?? '-' }}
                    </td>
                @else
                @endif
                {{-- <td>{{ $result->container_code }}</td>
                <td>{{ DateHelper::format($result->action_date) }}</td>
                <td>{{ DateHelper::format($result->tgl_selesai) ?? '-' }}</td> --}}

                <td>{{ $result->job_type }}</td>
                <td>{{ $result->root_cause }}</td>
                <td>{{ $result->material_size }}</td>
                <td>{{ $result->qty }}</td>
                <td>{{ $result->unit }}</td>
                <td>{{ number_format($result->unit_price) }}</td>
                <td>{{ number_format($result->price_estimation) }}</td>
                @if ($lastCt != $result->container_code)
                    <td rowspan="{{ $rowspan }}">{{ DateHelper::format($result->approve_date) }}</td>
                    <td rowspan="{{ $rowspan }}">{{ DateHelper::format($result->approve2_date) }}</td>
                    <td rowspan="{{ $rowspan }}">{{ DateHelper::format($result->approve3_date) }}</td>
                @endif
                {{-- <td>{{ DateHelper::format($result->approve_date) }}</td>
                <td>{{ DateHelper::format($result->approve2_date) }}</td>
                <td>{{ DateHelper::format($result->approve3_date) }}</td> --}}

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
