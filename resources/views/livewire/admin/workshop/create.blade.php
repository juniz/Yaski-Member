<div>
    <!--  Tambah modal -->
    <div wire:ignore.self class="modal fade tambah-workshop" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Workshop</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" wire:submit.prevent='simpan' enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input wire:model.defer='nama' type="text"
                                class="form-control @error('nama') is-invalid @enderror" autofocus>
                            @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="">Tanggal</label>
                            <div class="d-flex flex-row" style="gap: 10px">
                                <input type="date" class="form-control @error('tgl_mulai') is-invalid @enderror"
                                    wire:model.defer='tgl_mulai' placeholder="Tanggal mulai">
                                <input type="date" class="form-control @error('tgl_selesai') is-invalid @enderror"
                                    wire:model.defer='tgl_selesai' placeholder="Tanggal selesai">
                            </div>
                            @error('tgl_mulai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            @error('tgl_selesai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="">Lokasi</label>
                            <div class="d-flex flex-row" style="gap: 10px">
                                <input type="text" class="form-control @error('lat') is-invalid @enderror"
                                    wire:model.defer='lat' placeholder="Latitude">
                                <input type="text" class="form-control @error('lng') is-invalid @enderror"
                                    wire:model.defer='lng' placeholder="Langitude">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="gambar">Gambar</label>
                            <div class="input-group">
                                <input wire:model='gambar' type="file"
                                    class="form-control @error('gambar') is-invalid @enderror" id="gambar" name="gambar"
                                    accept="image/*" autofocus>
                            </div>
                            @error('gambar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <div class="text-start mt-2">
                                @if($gambar)
                                <img src="{{ $gambar->temporaryUrl() }}" alt="" style="width: 100%; height:200px">
                                @endif
                            </div>
                        </div>
                        <div class="mt-3 d-grid">
                            <button class="btn btn-primary waves-effect waves-light" type="submit">Tambahkan</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>