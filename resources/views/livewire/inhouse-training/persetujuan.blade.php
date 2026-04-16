<div>
    <div wire:ignore.self id="manual-inhouse-training-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Permintaan Inhouse Training</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" wire:submit.prevent='simpanManual'>
                        @csrf
                        <div class="mb-3">
                            <label class="form-label d-block">Tujuan Permintaan</label>
                            <div class="btn-group w-100" role="group" aria-label="Tujuan Permintaan">
                                <input type="radio" class="btn-check" id="manual_mode_registered" value="registered" wire:model="manual_tujuan_mode">
                                <label class="btn btn-outline-primary" for="manual_mode_registered">Fasyankes Terdaftar</label>

                                <input type="radio" class="btn-check" id="manual_mode_freetext" value="freetext" wire:model="manual_tujuan_mode">
                                <label class="btn btn-outline-primary" for="manual_mode_freetext">Fasyankes Belum Terdaftar</label>
                            </div>
                        </div>
                        @if($manual_tujuan_mode == 'registered')
                            <div class="mb-3">
                                <label for="manual_user_id" class="form-label">Fasyankes/User Terdaftar</label>
                                <select class="form-control @error('manual_user_id') is-invalid @enderror" id="manual_user_id" wire:model.defer='manual_user_id'>
                                    <option value="">Pilih Fasyankes/User</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->fasyankes->nama ?? $user->name }} - {{ $user->email }}</option>
                                    @endforeach
                                </select>
                                @error('manual_user_id')<div><span class="text-danger">{{ $message }}</span></div>@enderror
                            </div>
                        @else
                            <div class="mb-3">
                                <label for="manual_fasyankes" class="form-label">Nama Fasyankes</label>
                                <input type="text" class="form-control @error('manual_fasyankes') is-invalid @enderror" id="manual_fasyankes" wire:model.defer='manual_fasyankes'>
                                @error('manual_fasyankes')<div><span class="text-danger">{{ $message }}</span></div>@enderror
                            </div>
                        @endif
                        <div class="mb-3">
                            <label for="manual_nama_kegiatan" class="form-label">Nama Kegiatan</label>
                            <input type="text" class="form-control @error('manual_nama_kegiatan') is-invalid @enderror" id="manual_nama_kegiatan" wire:model.defer='manual_nama_kegiatan'>
                            @error('manual_nama_kegiatan')<div><span class="text-danger">{{ $message }}</span></div>@enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="manual_no_surat" class="form-label">Nomor Surat Masuk</label>
                                    <input type="text" class="form-control @error('manual_no_surat') is-invalid @enderror" id="manual_no_surat" wire:model.defer='manual_no_surat'>
                                    @error('manual_no_surat')<div><span class="text-danger">{{ $message }}</span></div>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="manual_tgl_surat" class="form-label">Tanggal</label>
                                    <input type="date" class="form-control @error('manual_tgl_surat') is-invalid @enderror" id="manual_tgl_surat" wire:model.defer='manual_tgl_surat'>
                                    @error('manual_tgl_surat')<div><span class="text-danger">{{ $message }}</span></div>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 d-grid">
                            <button class="btn btn-primary waves-effect waves-light" type="submit">Simpan dan Generate Surat</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self id="inhouse-training-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $requestInhouse->nama_kegiatan ?? 'Permintaan Inhouse Training' }} No. Surat : {{ $requestInhouse->no_surat ?? '-' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        @if($requestInhouse)
                            @if($requestInhouse->file)
                                <iframe src="{{ asset('storage/inhouse-training/'.$requestInhouse->file) }}" width="100%" height="600px" frameborder="0"></iframe>
                            @else
                                <div class="alert alert-info mb-0" role="alert">
                                    Permintaan ini dibuat manual oleh admin tanpa upload surat permintaan.
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-bs-target="#setuju-inhouse-training-modal" data-bs-toggle="modal" data-bs-dismiss="modal" class="btn btn-success waves-effect waves-light">Setujui</button>
                    <button type="button" data-bs-target="#tolak-inhouse-training-modal" data-bs-toggle="modal" data-bs-dismiss="modal" class="btn btn-danger waves-effect waves-light">Tolak</button>
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self id="setuju-inhouse-training-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Buat Surat Balasan dan Surat Tugas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" wire:submit.prevent='simpanSetuju'>
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="no_surat_balasan" class="form-label">Nomor Surat Balasan</label>
                                    <input type="text" class="form-control @error('no_surat_balasan') is-invalid @enderror" id="no_surat_balasan" wire:model.defer='no_surat_balasan'>
                                    @error('no_surat_balasan')<div><span class="text-danger">{{ $message }}</span></div>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="no_surat_tugas" class="form-label">Nomor Surat Tugas</label>
                                    <input type="text" class="form-control @error('no_surat_tugas') is-invalid @enderror" id="no_surat_tugas" wire:model.defer='no_surat_tugas'>
                                    @error('no_surat_tugas')<div><span class="text-danger">{{ $message }}</span></div>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tanggal_surat" class="form-label">Tanggal Surat</label>
                                    <input type="date" class="form-control @error('tanggal_surat') is-invalid @enderror" id="tanggal_surat" wire:model.defer='tanggal_surat'>
                                    @error('tanggal_surat')<div><span class="text-danger">{{ $message }}</span></div>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tanggal_kegiatan" class="form-label">Tanggal/Jadwal Kegiatan</label>
                                    <input type="date" class="form-control @error('tanggal_kegiatan') is-invalid @enderror" id="tanggal_kegiatan" wire:model.defer='tanggal_kegiatan'>
                                    @error('tanggal_kegiatan')<div><span class="text-danger">{{ $message }}</span></div>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="kepada" class="form-label">Kepada Yth.</label>
                                    <input type="text" class="form-control @error('kepada') is-invalid @enderror" id="kepada" wire:model.defer='kepada'>
                                    @error('kepada')<div><span class="text-danger">{{ $message }}</span></div>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="kota_tujuan" class="form-label">Kota Tujuan</label>
                                    <input type="text" class="form-control @error('kota_tujuan') is-invalid @enderror" id="kota_tujuan" wire:model.defer='kota_tujuan'>
                                    @error('kota_tujuan')<div><span class="text-danger">{{ $message }}</span></div>@enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="perihal" class="form-label">Hal/Perihal</label>
                                    <input type="text" class="form-control @error('perihal') is-invalid @enderror" id="perihal" wire:model.defer='perihal'>
                                    @error('perihal')<div><span class="text-danger">{{ $message }}</span></div>@enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="petugas_text" class="form-label">Nama PIC/Petugas</label>
                                    <textarea class="form-control @error('petugas_text') is-invalid @enderror" id="petugas_text" rows="4" wire:model.defer='petugas_text'></textarea>
                                    @error('petugas_text')<div><span class="text-danger">{{ $message }}</span></div>@enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="transport_nominal" class="form-label">Nominal Transport</label>
                                    <input type="text" class="form-control" id="transport_nominal" wire:model.defer='transport_nominal'>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="penginapan_nominal" class="form-label">Nominal Penginapan</label>
                                    <input type="text" class="form-control" id="penginapan_nominal" wire:model.defer='penginapan_nominal'>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="honor_nominal" class="form-label">Nominal Honor Narasumber</label>
                                    <textarea class="form-control" id="honor_nominal" rows="3" wire:model.defer='honor_nominal'></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 d-grid">
                            <button class="btn btn-primary waves-effect waves-light" type="submit">Generate Surat dan Setujui</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self id="tolak-inhouse-training-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tolak {{ $requestInhouse->nama_kegiatan ?? 'Permintaan' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" wire:submit.prevent='simpanTolak'>
                        @csrf
                        <div class="mb-3">
                            <label for="alasan" class="form-label">Alasan</label>
                            <textarea class="form-control @error('alasan') is-invalid @enderror" id="alasan"
                                wire:model.defer='alasan' name="alasan"></textarea>
                            @error('alasan')<div><span class="text-danger">{{ $message }}</span></div>@enderror
                        </div>
                        <div class="mt-3 d-grid">
                            <button class="btn btn-primary waves-effect waves-light" type="submit">Simpan</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self id="doc-inhouse-training-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $requestInhouse->nama_kegiatan ?? 'Surat Permintaan Inhouse Training' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        @if($requestInhouse)
                        <h6>Surat Permintaan</h6>
                        @if($requestInhouse->file)
                            <iframe src="{{ asset('storage/inhouse-training/'.$requestInhouse->file) }}" width="100%" height="600px" frameborder="0"></iframe>
                        @else
                            <div class="alert alert-info" role="alert">
                                Permintaan ini dibuat manual oleh admin tanpa upload surat permintaan.
                            </div>
                        @endif
                            @if($requestInhouse->file_balasan)
                            <h6 class="mt-4">Surat Balasan</h6>
                            <iframe src="{{ asset('storage/inhouse-training-balasan/'.$requestInhouse->file_balasan) }}" width="100%" height="600px" frameborder="0"></iframe>
                            @endif
                            @if($requestInhouse->file_tugas)
                            <h6 class="mt-4">Surat Tugas</h6>
                            <iframe src="{{ asset('storage/inhouse-training-tugas/'.$requestInhouse->file_tugas) }}" width="100%" height="600px" frameborder="0"></iframe>
                            @endif
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
