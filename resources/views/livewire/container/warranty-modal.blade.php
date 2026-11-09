<div>
    <button class="btn btn-xs btn-warning" data-toggle="modal" data-target="#warranty-modal-{{ $ct }}" type="button">Show</button>
    <!-- Modal -->
    <div class="modal fade" id="warranty-modal-{{ $ct }}" tabindex="-1" role="dialog" aria-labelledby="warranty-modalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="warranty-modalLabel">Informasi Garansi Container</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="d-flex">
                        <label class="font-weight-bold mr-2">Nomor CT :</label>
                        <p class="m-0">{{ $ct }}</p>
                    </div>
                    <div class="d-flex">
                        <label class="font-weight-bold mr-2">Garansi Pengadaan :</label>
                        <p class="m-0">{{ $ctWarranty }}</p>
                    </div>
                    <div class="d-flex">
                        <label class="font-weight-bold mr-2">Garansi Upgrade :</label>
                        <p class="m-0">{{ $upgradeWarranty }}</p>
                    </div>

                    <div class="d-flex">
                        <label class="font-weight-bold mr-2">Garansi Perbaikan Yang Masih Aktif :</label>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nomor Transaksi BAST</th>
                                    <th>Item Garansi</th>
                                    <th>Masa Garansi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bastWarranty as $warranty)
                                    <tr>
                                        <td>{{ $warranty->detail->delegationFromVendor->code }}</td>
                                        <td>{{ $warranty->contractDetail->job_type ?? '' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($warranty->warranty_start_date)->format('d-m-Y') ." s/d " . \Carbon\Carbon::parse($warranty->warranty_end_date)->format('d-m-Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">Tidak ada garansi aktif untuk container ini</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>
