<div>
    <div id="qrcode-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $transaction }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div wire:ignore class="d-flex flex-column">
                        <div style="width: 100%" id="reader"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
