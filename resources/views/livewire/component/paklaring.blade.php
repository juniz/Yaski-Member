<div>
    @if(!empty($paklaring))
        @if($paklaring->stts == 'proses')
        <div class="alert alert-warning alert-dismissible alert-label-icon label-arrow fade show"
            role="alert">
            <i class="mdi mdi-block-helper label-icon"></i><strong>Paklaring belum disetujui oleh admin</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <iframe src="{{ asset('storage/pakelaring/'. $paklaring->file) }}" frameborder="1"
            width="100%" height="500vh"></iframe>
        {{-- <div class="alert alert-warning" role="alert">
            Paklaring belum disetujui oleh admin
        </div> --}}
        @elseif($paklaring->stts == 'ditolak')
        <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade show"
            role="alert">
            <i class="mdi mdi-block-helper label-icon"></i><strong>Paklaring ditolak oleh admin</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <div class="alert alert-danger" role="alert">
            {{ $paklaring->alasan }}
        </div>
        @elseif($paklaring->stts == 'disetujui')
        <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show"
            role="alert">
            <i class="mdi mdi-block-helper label-icon"></i><strong>Paklaring disetujui oleh admin</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <iframe src="{{ asset('storage/persetujuan/'. $paklaring->file_verif) }}" frameborder="1"
            width="100%" height="500vh"></iframe>
        {{-- <div class="alert alert-success" role="alert">
            Paklaring disetujui oleh admin
        </div> --}}
        @endif
        @endif
        {{-- @if(empty($paklaring))
        <h6 class="text-center">Data Kosong</h6>
        @else
        <iframe src="{{ asset('storage/pakelaring/'. $paklaring->file) }}" frameborder="1"
            width="100%" height="500vh"></iframe>
        <div class="d-flex flex-row justify-content-center mt-3">
            <button id="btn-unggah-paklaring" class="btn btn-secondary btn-block"><i class="bx bx-download"></i> Unduh Paklaring</button>
        </div>
        @endif --}}
</div>