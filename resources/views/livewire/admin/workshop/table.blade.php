<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-4">
                    <div class="d-flex flex-row justify-content-end mb-2">
                        <div class="text-sm-end">
                            <a type="button" href="{{ route('workshop.create') }}"
                                class="btn btn-sm btn-secondary btn-rounded waves-effect waves-light me-2"><i
                                    class="mdi mdi-plus me-1"></i> Tambah </a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Lokasi</th>
                                    <th>Tgl Mulai</th>
                                    <th>Tgl Selesai</th>
                                    <th>Menu</th>
                                </tr>
                            </thead>
                            @forelse($workshops as $workshop)
                                <tbody x-data="{ open: false }">
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $workshop->nama }}</td>
                                        <td>{{ $workshop->lokasi }}</td>
                                        <td>{{ $workshop->tgl_mulai }}</td>
                                        <td>{{ $workshop->tgl_selesai }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button 
                                                    type="button" 
                                                    x-bind:class="! open ? 'btn btn-secondary' : 'btn btn-danger' " 
                                                    @click="open = !open" 
                                                    ><span x-text="open ? 'Tutup' : 'Detail'"></span>
                                                </button>
                                                <button type="button" wire:click='setStatus("{{$workshop->id}}")' class="btn {{ $workshop->stts == '1' ? 'btn-success' : 'btn-danger' }}">{{ $workshop->stts == '1' ? 'Aktif' : 'Tidak Aktif' }}</button>
                                            </div>
                                            
                                        </td>
                                    </tr>
                                    <td x-show="open" colspan="6" x-transition>
                                        <div class="d-flex flex-row gap-4 mb-3">
                                            <img src="{{ asset('/storage/workshop/'.$workshop->gambar) }}" alt=""
                                                class="img-thumbnail w-25">
                                            <div class="w-50">
                                                {!! $workshop->deskripsi !!}
                                            </div>   
                                            <div class="w-25">
                                                <h6>Daftar Harga</h6>
                                                <ul>
                                                    @forelse($workshop->paket as $paket)
                                                        <li class="mb-2">
                                                            {{ $paket->nama }} : {{ $paket->harga }}
                                                            <button wire:click="$emit('ubahPaket', '{{$paket->id}}')" class="btn btn-sm btn-primary"><i class="bx bx-edit"></i></button> 
                                                            <button wire:click="$emit('hapusPaket', '{{$paket->id}}')" class="btn btn-sm btn-danger"><i class="bx bx-trash"></i></button>
                                                        </li>
                                                    @empty
                                                        <li>Tidak ada paket</li>
                                                    @endforelse
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row justify-content-between">
                                            <div class="text-mute">
                                                kuota : {{ $workshop->kuota }}
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row">
                                            <div class="mx-auto">
                                                <div class="btn-group">
                                                    <a href="{{ url('/workshop/'.$workshop->id.'/edit') }}" type="button" class="btn btn-sm btn-success"><i class="bx bx-edit"> Ubah</i></a>
                                                    <button type="button" wire:click="$emit('openModalHarga', '{{$workshop->id}}')" class="btn btn-sm btn-primary"><i class="bx bx-lock"></i> Harga</button>
                                                    <a href="{{ route('workshop.peserta', $workshop->id) }}" class="btn btn-sm btn-secondary"><i class="bx bx-user"></i> Peserta</a>
                                                    <a href="{{ route('workshop.daftar.hadir', $workshop->id) }}" class="btn btn-sm btn-secondary"><i class="bx bx-user"></i> Daftar Hadir</a>
                                                    <a href="{{ route('workshop.sertifikat', $workshop->id) }}" class="btn btn-sm btn-secondary"><i class="bx bx-user"></i> Sertifikat</a>
                                                    <a href="{{ route('workshop.setting', $workshop->id) }}" class="btn btn-sm btn-secondary"><i class="bx bx-user"></i> Setting</a>
                                                    <button type="button" wire:click="$emit('confirmHapusWorkshop', '{{$workshop->id}}')" class="btn btn-sm btn-danger"><i class="bx bx-trash"></i> Hapus</button>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tbody>
                                @empty
                                <tbody>
                                    <tr>
                                        <td class="text-center" colspan="6">
                                            <h6>Data Tidak ada</h6>
                                        </td>
                                    </tr>
                                </tbody>
                            @endforelse
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>