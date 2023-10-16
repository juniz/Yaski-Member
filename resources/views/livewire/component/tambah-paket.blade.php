<div>
    <!-- sample modal content -->
    <div wire:ignore.self id="tambah-paket-modal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahPaketModalLabel">Paket Harga</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent='simpan'>
                        <div class="mb-3">
                            <label for="nama">Nama</label>
                            <input wire:model.defer='nama' id="nama" name="nama" type="text" class="form-control @error('nama') is-invalid @enderror">
                            @error('nama')<div><span class="text-danger">{{ $message }}</span></div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="harga">Harga</label>
                            <input wire:model.defer='harga' id="harga" name="harga" type="number" class="form-control @error('harga') is-invalid @enderror">
                            @error('harga')<div><span class="text-danger">{{ $message }}</span></div>@enderror
                        </div>
                        <div class="mb-3">
                            <button type="submit"  class="btn btn-primary btn-block">
                                @if($state == 'tambah')
                                Simpan
                                @else
                                Ubah
                                @endif
                            </button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
