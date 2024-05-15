<div>
    <div class="row align-items-center">
        <div class="col-md-6">
            <div class="mb-3">
                <h5 class="card-title">Jumlah Member <span class="text-muted fw-normal ms-2">({{ $members->total() }})</span></h5>
            </div>
        </div>

        <div class="col-md-6">
            <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                <div class="col-xs-3">
                    <input class="form-control" wire:model.debounce.500ms='search' type="text"
                        placeholder="Cari member .....">
                </div>
                <div>
                    <button wire:click='$emit("tambah-user")' class="btn btn-secondary"><i class="bx bx-plus me-1"></i>
                        Tambah</button>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Fasyankes</th>
                            <th>Email</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($members as $member)
                        @if(!$member->hasRole('super-admin'))
                        <tr>
                            <td><img src="{{ URL::asset('storage/avatar/'.$member->avatar) }}" alt=""
                                    class="avatar-sm rounded-circle me-2"><a class="text-body">{{ $member->name }}</a>
                            </td>
                            <td>
                                @if($this->status($member->id))
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="blue" class="bi bi-patch-check-fill" viewBox="0 0 16 16">
                                    <path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708"/>
                                  </svg>
                                @endif
                                {{ $member->fasyankes->nama ?? 'Fasyankes masih kosong' }}
                            </td>
                            <td>{{ $member->email }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bx bx-dots-horizontal-rounded font-size-20"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" wire:click='$emit("edit-user", {{$member->id}})' href="#">
                                            <i class="bx bx-edit me-1"></i>Edit
                                        </a>
                                        <a class="dropdown-item" wire:click='$emit("changePassword", {{$member->id}})' href="#">
                                            <i class="bx bx-edit me-1"></i>Rubah Password
                                        </a>
                                        <a class="dropdown-item" wire:click='modalPakelaring("{{$member->id}}")' href="#"><i class="bx bx-envelope me-1"></i>Paklaring</a>
                                        <a class="dropdown-item" href="{{ route('members.edit', $member->id) }}"><i class="bx bx-user me-1"></i>Profile</a>
                                        <a class="dropdown-item" wire:click='confirmDelete("{{$member->id}}")' href="#"><i class="bx bx-trash me-1"></i>Hapus</a>
                                    </div>
                                </div>
                                {{-- <div class="btn-group">
                                    <button type="button" wire:click='$emit("edit-user", {{$member->id}})'
                                        class="btn btn-sm btn-success"><i class="bx bx-edit"></i></button>
                                    <button type="button" wire:click='modalPakelaring("{{$member->id}}")'
                                        class="btn btn-sm btn-primary"><i class="bx bx-file"></i></button>
                                    <button type="button" wire:click='kwitansi("{{$member->id}}")'
                                        class="btn btn-sm btn-info"><i class="bx bx-envelope"></i></button>
                                    <a type="button" href="{{ route('members.edit', $member->id) }}"
                                        class="btn btn-sm btn-secondary"><i class="bx bx-user"></i></a>
                                    <button type="button" wire:click='confirmDelete("{{$member->id}}")'
                                        class="btn btn-sm btn-danger"><i class="bx bx-trash"></i></button>
                                </div> --}}
                            </td>
                        </tr>
                        @endif
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Data tidak ditemukan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- end row -->
    {{-- <div class="row">
        @foreach ($members as $member)
        <div class="col-xl-4 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="dropdown float-end">
                        <a class="text-muted dropdown-toggle font-size-16" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true">
                            <i class="bx bx-dots-horizontal-rounded"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="#">Edit</a>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Remove</a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div>
                            <img src="{{ URL::asset('images/avatars/'.$member->avatar) }}" alt=""
                                class="avatar-lg rounded-circle img-thumbnail">
                        </div>
                        <div class="flex-1 ms-3">
                            <h5 class="font-size-15 mb-1"><a href="#" class="text-dark">{{ $member->name }}</a></h5>
                            <p class="text-muted mb-0">{{ $member->fasyankes->nama ?? 'Fasyankes masih
                                kosong' }}</p>
                        </div>
                    </div>
                    <div class="mt-3 pt-1">
                        <p class="text-muted mb-0"><i
                                class="mdi mdi-phone font-size-15 align-middle pe-2 text-primary"></i>
                            {{ $member->fasyankes->telp ?? '-' }}</p>
                        <p class="text-muted mb-0 mt-2"><i
                                class="mdi mdi-email font-size-15 align-middle pe-2 text-primary"></i>
                            {{ $member->fasyankes->email ?? '-' }}</p>
                        <p class="text-muted mb-0 mt-2"><i
                                class="mdi mdi-google-maps font-size-15 align-middle pe-2 text-primary"></i>
                            {{ $member->fasyankes->alamat ?? '-' }}</p>
                    </div>
                </div>

                <div class="btn-group" role="group">
                    <a href="{{ route('members.edit', $member->id) }}" type="button"
                        class="btn btn-outline-light text-truncate"><i class="uil uil-user me-1"></i>
                        Profile</a>
                    <button type="button" wire:click='modalPakelaring("{{$member->id}}")'
                        class="btn btn-outline-light text-truncate"><i class="uil uil-envelope-alt me-1"></i>
                        Pakelaring</button>
                </div>
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
        @endforeach
    </div> --}}
    <!-- end row -->

    <div class="d-flex flex-row">
        <div class="mx-auto">
            {{ $members->onEachSide(1)->links() }}
        </div>
    </div>
    <!-- end row -->

    <div id="pakelaring-modal" wire:ignore.self class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Dokumen Pakelaring</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if(empty($pakelaring))
                    <h6 class="text-center text-mute">Data Pakelaring masih kosong</h6>
                    @else
                    <iframe src="{{ asset('storage/pakelaring/'.$pakelaring->file) }}" frameborder="0" height="500px"
                        width="100%"></iframe>
                    @endif
                </div>
                <div class="modal-footer">
                    <div class="d-flex flex-row gap-4">
                        <form wire:submit.prevent="simpan">
                            <div class="input-group">
                                <input class="form-control @error('file') is-invalid @enderror" wire:model='file'
                                    type="file" name="upload-pakelaring" id="upload-pakelaring"
                                    placeholder="Upload berkas pakelaring">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-dark" type="button">Upload</button>
                                </div>
                                @error('file')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </form>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>