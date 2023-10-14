<div>
    <div wire:ignore.self id="persetujuan-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="persetujuan-modal-label">Persetujuan Paklaring No. Surat : {{ $paklaring->no_surat ?? '-' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        @if($paklaring)
                        <iframe src="{{ asset('storage/pakelaring/'.$paklaring->file) }}" width="100%" height="600px" frameborder="0"></iframe>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-bs-target="#setuju-modal" data-bs-toggle="modal" data-bs-dismiss="modal" class="btn btn-success waves-effect waves-light">Setujui</button>
                    <button type="button" data-bs-target="#tolak-modal" data-bs-toggle="modal" data-bs-dismiss="modal" class="btn btn-danger waves-effect waves-light">Tolak</button>
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self id="setuju-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="setuju-modal-label">Persetujuan Paklaring No. Surat : {{ $paklaring->no_surat ?? '-' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" wire:submit.prevent='simpanSetuju'>
                        @csrf
                        <div class="mb-3">
                            <label for="file">Unggah Dokumen</label>
                            <div class="input-group">
                                <input type="file" wire:model.defer='file' class="form-control @error('file') is-invalid @enderror" id="file"
                                    name="file" autofocus>
                                <label class="input-group-text" for="dokumen">Unggah</label>
                            </div>
                            @error('file')<div><span class="text-danger">{{ $message }}</span></div>@enderror
                        </div>
                        <div class="mt-3 d-grid">
                            <button class="btn btn-primary waves-effect waves-light UpdatePaklaring"
                                type="submit">Unggah</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self id="tolak-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="setuju-modal-label">Paklaring No. Surat : {{ $paklaring->no_surat ?? '-' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" wire:submit.prevent='simpanTolak'>
                        @csrf
                        <div class="mb-3">
                            <label for="alasan" class="form-label">Alasan</label>
                            <textarea type="text" class="form-control @error('no_surat') is-invalid @enderror" id="alasan"
                                wire:model.defer='alasan' name="no_surat" autofocus></textarea>
                            @error('alasan')<div><span class="text-danger">{{ $message }}</span></div>@enderror
                        </div>
                        <div class="mt-3 d-grid">
                            <button class="btn btn-primary waves-effect waves-light UpdatePaklaring"
                                type="submit">Simpan</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self id="doc-persetujuan-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="doc-persetujuan-modal-label">Persetujuan Paklaring</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        @if($paklaring)
                        <iframe src="{{ asset('storage/persetujuan/'.$paklaring->file_verif) }}" width="100%" height="600px" frameborder="0"></iframe>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>
