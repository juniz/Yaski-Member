<div>
    <form class="form-horizontal" wire:submit.prevent='simpan'>
        @csrf
        <div class="mb-3">
            <label for="nama_kegiatan" class="form-label">Nama Kegiatan</label>
            <input type="text" class="form-control @error('nama_kegiatan') is-invalid @enderror" id="nama_kegiatan"
                wire:model.defer='nama_kegiatan' name="nama_kegiatan">
            @error('nama_kegiatan')<div><span class="text-danger">{{ $message }}</span></div>@enderror
        </div>

        <div class="mb-3">
            <label for="no_surat" class="form-label">No. Surat</label>
            <input type="text" class="form-control @error('no_surat') is-invalid @enderror" id="no_surat"
                wire:model.defer='no_surat' name="no_surat">
            @error('no_surat')<div><span class="text-danger">{{ $message }}</span></div>@enderror
        </div>

        <div class="mb-3">
            <label for="tgl_surat" class="form-label">Tanggal Surat</label>
            <input type="date" class="form-control @error('tgl_surat') is-invalid @enderror" id="tgl_surat"
                wire:model.defer='tgl_surat' name="tgl_surat">
            @error('tgl_surat')<div><span class="text-danger">{{ $message }}</span></div>@enderror
        </div>

        <div class="mb-3">
            <label for="file">Surat Permintaan Pendampingan Inhouse Training</label>
            <div class="input-group">
                <input type="file" wire:model.defer='file' class="form-control @error('file') is-invalid @enderror" id="file"
                    name="file">
                <label class="input-group-text" for="file">Unggah PDF</label>
            </div>
            @error('file')<div><span class="text-danger">{{ $message }}</span></div>@enderror
        </div>

        <div class="mt-3 d-grid">
            <button class="btn btn-primary waves-effect waves-light" type="submit">
                <i class="bx bx-upload"></i> Simpan Permintaan
            </button>
        </div>
    </form>
</div>
