<div>
    <div class="row">
        {{-- input filter by company --}}
        <div class="col-lg-12">

            <div class="row mb-2">
                {{-- <div class="col-sm-4 col-md-4 col-lg-4">
                    <div class="form-group">
                        <label for=""> <strong> Search Container Record: </strong></label>
                    </div>
                </div> --}}

                <div class="col-sm-8 col-md-8 col-lg-8 d-flex flex-column">
                    {{-- <button class="btn btn-primary align-self-end" wire:click="export">Export Ke Excel</button> --}}
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="container"><strong>Container</strong></label>
                        <select wire:model="container" class="form-control select2-custom2" id="container">
                            <option value="">--- Pilih Container ---</option>
                            @foreach ($containers as $container)
                                <option value="{{ $container->code }}">{{ $container->code }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <hr class="border border-primary">

    <div class="row">
        <div class="col-lg-12">

            <ul class="list-group mb-3">
                <li class="list-group-item list-group-item-info" aria-current="true"><strong>Ditemukan
                        {{ $records->isEmpty() ? '0' : number_format($records->total(), 0) }} data</strong></li>
            </ul>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th scope="col">No CT</th>
                            <th scope="col">No Trx</th>
                            <th scope="col">Creator</th>
                            <th scope="col">Location</th>
                            <th scope="col">Status</th>
                            <th scope="col">Type</th>
                            {{-- <th scope="col">Remarks</th> --}}
                            <th scope="col">Asal/Tujuan</th>
                            <th scope="col">Transaction Date</th>
                            <th scope="col">Input Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($records as $ct)
                            <tr>
                                <td>
                                    <strong>{{ $ct->container_code }}</strong>
                                </td>
                                <td>
                                    @if ($ct->activity == 'INSPEKSI')
                                        <a target="_blank"
                                            href="{{ route('console.inspection.detail', $ct->id) }}">{{ $ct->no_transaction }}</a>
                                    @elseif ($ct->activity == 'AKT. HARIAN')
                                        <a target="_blank"
                                            href="{{ route('console.container-daily-activity.detail', $ct->id) }}">{{ $ct->no_transaction }}</a>
                                    @elseif ($ct->activity == 'BAST1')
                                        <a target="_blank"
                                            href="{{ route('console.delegation-to-vendor.detail', $ct->id) }}">{{ $ct->no_transaction }}</a>
                                    @else
                                        <a target="_blank"
                                            href="{{ route('console.delegation-from-vendor.detail', $ct->id) }}">{{ $ct->no_transaction }}</a>
                                    @endif
                                </td>
                                <td>
                                    {{ $ct->creator }}
                                </td>
                                <td>
                                    {{ $ct->location }}
                                </td>
                                <td>
                                    {{ $ct->status }}
                                </td>
                                <td>
                                    {{ $ct->activity == 'AKT. HARIAN' ? $ct->activity . ' - ' . $ct->remarks : $ct->activity }}
                                </td>
                                {{-- <td>
                                {{ $ct->remarks }}
                            </td> --}}
                                <td>
                                    {{ $ct->type }}
                                </td>
                                <td>
                                    {{ isset($ct->action_date) ? \Carbon\Carbon::parse($ct->action_date)->format('d-m-Y') : '-' }}
                                </td>
                                <td>
                                    {{ isset($ct->created_at) ? \Carbon\Carbon::parse($ct->created_at)->format('d-m-Y') : '-' }}
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="11">Opps! Data tidak di temukan.</td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>
            </div>
            <div class="d-flex justify-content-end">
                {{ $records->isEmpty() ? '-' : $records->links() }}
            </div>
        </div>
    </div>


</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.select2-custom2').select2({
                theme: "bootstrap",
            });

            $('.select2-custom2').on('change', function(e) {
                @this.set('container', e.target.value);
            });
        });
    </script>
@endpush
