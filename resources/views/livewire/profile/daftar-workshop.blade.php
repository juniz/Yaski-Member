<div>
    <!--  Tambah team modal -->
    <div wire:ignore.self class="modal fade daftar-workshop-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Daftar Workshop</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>Pilih peserta ikut workshop :</h6>
                    <ul class="list-group">
                        @for($i = 0; $i < $jmlForm; $i++)
                        <li class="list-group-item mt-3">
                            <x-ui.input label="Nama" id="nama-{{ $i}}" class="uppercase" wire:model='nama.{{$i}}' live/>
                            <div class="mb-3"></div>
                            <x-ui.select label="Jenis Kelamin" id="jenis_kelamin-{{ $i }}" wire:model='jenis_kelamin.{{$i}}' live>
                                <option value="">Pilih jenis kelamin</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </x-ui.select>
                            <div class="mb-3"></div>
                            <x-ui.input label='Email' class="lowercase" id="email-{{ $i }}" wire:model='email.{{$i}}' live/>
                            <div class="mb-3"></div>
                            <x-ui.input label='No. HP' id="no_hp-{{ $i }}" wire:model='telp.{{$i}}' live/>
                            <div class="mb-3"></div>
                            <x-ui.select label="Baju" id="baju-{{ $i }}" wire:model='baju.{{$i}}' live>
                                <option value="">Pilih ukuran baju</option>
                                <option value="S">S</option>
                                <option value="M">M</option>
                                <option value="L">L</option>
                                <option value="XL">XL</option>
                                <option value="XXL">XXL</option>
                            </x-ui.select>
                            <div class="mb-3"></div>
                            <x-ui.select label="Harga" id="harga-{{ $i }}" wire:model='harga.{{$i}}' live>
                                <option value="">Pilih harga</option>
                                @foreach($listHarga as $harga)
                                <option value="{{$harga->id}}">{{ $harga->nama }} - Rp {{ number_format($harga->harga, 2, ",", ".") }}</option>
                                @endforeach
                            </x-ui.select>
                            @if($i > 0)
                            <div class="d-grid">
                                <button wire:click='hapusForm({{$i}})' class="btn btn-danger mt-3">Hapus Peserta</button>
                            </div>
                            @endif
                        </li>
                        @endfor
                    </ul>
                    <div class="d-grid mt-3">
                        <button wire:click='tambahForm' class="btn btn-success waves-effect waves-light">Tambah Peserta</button>
                    </div>
                    @if($errors)
                    <ul class="mt-3">
                        @foreach($errors->all() as $error)
                        <li class="text-danger">{{ $error }}</li>
                        @endforeach
                    </ul>
                    @endif
                    <div class="d-grid mt-3">
                        <div class="btn-group gap-4">
                            <button type="button" data-bs-dismiss="modal" class="btn btn-danger waves-effect waves-light">Tutup</button>
                            <button type="button" wire:click='simpan' class="btn btn-primary waves-effect waves-light">Daftar</button>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
