<div>
    {{-- Change Password Modal --}}
    <div wire:ignore.self class="modal fade" id="changePaymentModal" tabindex="-1" aria-labelledby="changePaymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePaymentModalLabel">Ubah Data Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- Change Password Form --}}
                    <form wire:submit.prevent="simpan">
                        <x-ui.input label="Nama" id="nama" class="uppercase" wire:model='nama' live/>
                            <div class="mb-3"></div>
                            <x-ui.select label="Jenis Kelamin" id="jenis_kelamin" wire:model='jenis_kelamin' live>
                                <option value="">Pilih jenis kelamin</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </x-ui.select>
                            <div class="mb-3"></div>
                            <x-ui.input label='Email' class="lowercase" id="email" wire:model='email' live/>
                            <div class="mb-3"></div>
                            <x-ui.input label='No. HP' id="telp" wire:model='telp' type='number' live/>
                            <div class="mb-3"></div>
                            {{-- <x-ui.select label="Baju" id="baju-{{ $i }}" wire:model='baju' live>
                                <option value="">Pilih ukuran baju</option>
                                <option value="S">S</option>
                                <option value="M">M</option>
                                <option value="L">L</option>
                                <option value="XL">XL</option>
                                <option value="XXL">XXL</option>
                            </x-ui.select> --}}
                            <div class="mb-3"></div>
                            <x-ui.select label="Harga" id="harga" wire:model='harga' live>
                                <option value="">Pilih harga</option>
                                @if($paket)
                                @forelse($paket as $harga)
                                <option value="{{$harga->id}}">{{ $harga->nama }} - Rp {{ number_format($harga->harga, 2, ",", ".") }}</option>
                                @empty
                                <option value="">Tidak ada paket</option>
                                @endforelse
                                @endif
                            </x-ui.select>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>