<div>
    <button class="btn btn-secondary btn-sm d-flex align-items-center me-2" data-toggle="modal" data-target="#qr-modal"
        type="button">
        <i class="fa fa-qrcode"></i> <span class="ms-1">QRcode</span>
    </button>
    <!-- Modal -->
    <div class="modal fade" id="qr-modal" tabindex="-1" role="dialog" aria-labelledby="warranty-modalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="warranty-modalLabel">Scan QR to connect device</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body d-flex justify-content-center align-items-center">
                    @if ($qrcode)
                        <img src="data:image/png;base64,{{ base64_encode($qrcode) }}" alt="QR Code">
                    @else
                        @if ($errorMessage)
                            <p>{{ $errorMessage }}</p>
                        @else
                            <p>Failed to fetch QR code image.</p>
                        @endif
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>
