<div>
    <form class="form-horizontal" wire:submit.prevent='simpan'>
        @csrf
        <div class="mb-3">
            <label for="No_surat" class="form-label">No. Surat</label>
            <input type="text" class="form-control @error('no_surat') is-invalid @enderror" id="no_surat"
                wire:model.defer='no_surat' name="no_surat" placeholder="Masukkan No. Surat"
                autofocus>
            @error('no_surat')<div><span class="text-danger">{{ $message }}</span></div>@enderror
        </div>

        <div class="mb-3">
            <label for="tgl_pakai" class="form-label">Tanggal</label>
            <input type="date" class="form-control @error('tgl_pakai') is-invalid @enderror" id="tgl_pakai"
                wire:model.defer='tgl_pakai' name="tgl_pakai" placeholder="Masukkan tanggal"
                autofocus>
            @error('tgl_pakai')<div><span class="text-danger">{{ $message }}</span></div>@enderror
        </div>

        <div class="mb-3">
            <label for="file">Dokumen paklaring</label>
            <div class="input-group">
                <input type="file" wire:model.defer='file' class="form-control @error('file') is-invalid @enderror" id="file"
                    name="file" autofocus>
                <label class="input-group-text" for="dokumen">Unggah Paklaring</label>
            </div>
            @error('file')<div><span class="text-danger">{{ $message }}</span></div>@enderror
        </div>

        <div class="mt-3 d-grid">
            <button class="btn btn-primary waves-effect waves-light UpdatePaklaring"
                type="submit">Unggah</button>
        </div>
    </form>
</div>
