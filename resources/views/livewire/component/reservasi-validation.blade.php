<div>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title d-flex justify-content-center">Konfirmasi Pembayaran</h5>
            <div class="card-body">
                <div class="d-flex mt-3 justify-content-center">
                    {{-- <div class="timer" x-data="timer(new Date().setDate(new Date().getDate() + 1))" x-init="init();">
                        <h1 x-text="time().days"></h1>
                        <h1 x-text="time().hours"></h1>
                        <h1 x-text="time().minutes"></h1>
                        <h1 x-text="time().seconds"></h1>
                    </div> --}}
                    <h4>
                        @if($reservasi->status == 'pesan')
                        <span class="badge bg-warning text-dark">Menunggu Pembayaran</span>
                        @elseif($reservasi->status == 'proses')
                        <span class="badge bg-info text-dark">Menunggu Konfirmasi</span>
                        @elseif($reservasi->status == 'selesai')
                        <span class="badge bg-success text-dark">Selesai</span>
                        @endif
                    </h4>
                </div>
                <form wire:submit.prevent='simpan'>
                    <div class="mb-4">
                        <label for="bukti">Unggah Bukti Pembayaran</label>
                        <div class="input-group">
                            <input wire:model='bukti' type="file"
                                class="form-control @error('bukti') is-invalid @enderror" id="bukti" name="bukti"
                                accept="image/*" autofocus>
                        </div>
                        @error('bukti') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="d-flex flex-row justify-content-center gap-4">
                        <button type="button" class="btn btn-danger">Batal</button>
                        <button type="submit" class="btn btn-primary">Konfirmasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
