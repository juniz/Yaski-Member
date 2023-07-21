<div>
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-row justify-content-between">
                <h4 class="card-title text-uppercase mb-0">{{ $fasyankes->nama ?? 'Data Fasyankes Kosong' }}
                </h4>
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                    data-bs-target=".update-fasyankes"><i class="bx bx-plus me-1"></i>@if(empty($fasyankes))
                    Tambah Fasyankes @else Ubah
                    Fasyankes @endif</button>
            </div>
        </div>

        <div class="card-body">
            @if(!empty($fasyankes))
            <div>
                <div class="pb-3">
                    <h5 class="font-size-15">Kode :</h5>
                    <div class="text-muted">
                        <p class="mb-2">{{ $fasyankes->kode }}</p>
                    </div>
                </div>

                <div class="pt-3">
                    <h5 class="font-size-15">Jenis Fasyankes :</h5>
                    <div class="text-muted">
                        <p>{{ $fasyankes->jenis }}</p>
                    </div>
                </div>

                <div class="pt-3">
                    <h5 class="font-size-15">Kelas :</h5>
                    <div class="text-muted">
                        <p>{{ $fasyankes->kelas }}</p>
                    </div>
                </div>

                <div class="pt-3">
                    <h5 class="font-size-15">Telp :</h5>
                    <div class="text-muted">
                        <p>{{ $fasyankes->telp }}</p>
                    </div>
                </div>

                <div class="pt-3">
                    <h5 class="font-size-15">Email :</h5>
                    <div class="text-muted">
                        <p>{{ $fasyankes->email }}</p>
                    </div>
                </div>

                <div class="pt-3">
                    <h5 class="font-size-15">Direktur :</h5>
                    <div class="text-muted">
                        <p>{{ $fasyankes->direktur }}</p>
                    </div>
                </div>

                <div class="pt-3">
                    <h5 class="font-size-15">Alamat :</h5>
                    <div class="text-muted">
                        <p>{{ $fasyankes->alamat }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <!-- end card body -->
    </div>
    <!-- end card -->
    <!--  Update Fasyankes -->
    <div class="modal fade update-fasyankes" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Data Fasyankes</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="POST" enctype="multipart/form-data" id="update-fasyankes">
                        @csrf
                        <input type="hidden" value="{{ Auth::user()->id }}" id="data_id">
                        <div class="mb-3">
                            <label for="kode">Kode Fasyankes</label>
                            <input type="text" value="{{$fasyankes->kode ?? ''}}"
                                class="form-control @error('kode') is-invalid @enderror" id='kode' name="kode"
                                autofocus>
                            <div class="text-danger" id="kodeError" data-ajax-feedback="kode"></div>
                        </div>
                        <div class="mb-3">
                            <label for="nama">Nama Fasyankes</label>
                            <input type="text" value="{{$fasyankes->nama ?? ''}}" class=" form-control @error('nama') is-invalid
                        @enderror" id='nama' name="nama">
                            <div class="text-danger" id="namaError" data-ajax-feedback="nama"></div>
                        </div>
                        <div class="mb-3">
                            <label for="jenis" class="form-label font-size-13 text-muted">Jenis</label>
                            <select class="form-control @error('jenis') is-invalid @enderror" data-trigger name="jenis"
                                id="jenis" placeholder="Jenis Fasyankes">
                                <option value="">Pilih jenis</option>
                                @foreach($jenis as $j)
                                <option value="{{$j}}" @if($fasyankes->jenis == $j) selected @endif>{{$j}}</option>
                                @endforeach
                            </select>
                            <div class="text-danger" id="jenisError" data-ajax-feedback="jenis"></div>
                        </div>

                        <div class="mb-3">
                            <label for="kelas">Kelas</label>
                            <select type="text" value="{{$fasyankes->kelas ?? ''}}"
                                class="form-control @error('kelas') is-invalid @enderror" data-trigger id='kelas'
                                name="kelas">
                                <option value="">Pilih kelas</option>
                                @foreach($kelas as $k)
                                <option value="{{$k}}" @if($fasyankes->kelas == $k) selected @endif>{{$k}}</option>
                                @endforeach
                            </select>
                            <div class="text-danger" id="kelasError" data-ajax-feedback="kelas"></div>
                        </div>

                        <div class="mb-3">
                            <label for="telp">Telp</label>
                            <input type="text" value="{{$fasyankes->telp ?? ''}}"
                                class="form-control @error('telp') is-invalid @enderror" id='telp' name="telp">
                            <div class="text-danger" id="telpError" data-ajax-feedback="telp"></div>
                        </div>

                        <div class="mb-3">
                            <label for="email">Email</label>
                            <input type="email" value="{{$fasyankes->email ?? ''}}"
                                class="form-control @error('email') is-invalid @enderror" id='email' name="email">
                            <div class="text-danger" id="emailError" data-ajax-feedback="email"></div>
                        </div>

                        <div class="mb-3">
                            <label for="direktur">Nama Direktur</label>
                            <input type="text" value="{{$fasyankes->direktur ?? ''}}" class="form-control @error('direktur') is-invalid
                    @enderror" id='direktur' name="direktur">
                            <div class="text-danger" id="direkturError" data-ajax-feedback="telp"></div>
                        </div>

                        <div class="col-12">
                            <div class="mb-3">
                                <label for="provinsi" class="form-label font-size-13 text-muted">Provinsi</label>
                                <select class="form-control" data-trigger name="provinsi" id="provinsi"
                                    placeholder="Cari Provinsi">
                                    <option value="">Pilih provinsi</option>
                                    @foreach ($provinces as $province)
                                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                                    @endforeach
                                </select>
                                <div class="text-danger" id="provinsiError" data-ajax-feedback="provinsi"></div>
                            </div>
                        </div>

                        <div class="col-12 kabupaten-form">
                            <div class="mb-3">
                                <label for="kabupaten" class="form-label font-size-13 text-muted">Kabupaten /
                                    Kota</label>
                                <select class="form-control" name="kabupaten" id="kabupaten"
                                    placeholder="Cari Kabupaten">
                                </select>
                                <div class="text-danger" id="kabupatenError" data-ajax-feedback="kabupaten"></div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="alamat">Alamat Fasyankes</label>
                            <textarea type="text" class="form-control @error('alamat') is-invalid @enderror" id='alamat'
                                name="alamat" cols="3">{{$fasyankes->alamat ?? ''}}
                    </textarea>
                            <div class="text-danger" id="alamatError" data-ajax-feedback="alamat"></div>
                        </div>

                        <div class="mb-3">
                            <label for="image">Profile Fasyankes</label>
                            <div class="input-group">
                                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                                    name="image" autofocus>
                                <label class="input-group-text" for="image">Upload</label>
                            </div>
                            <div class="text-start mt-2">
                                <img src="@if (!empty($fasyankes->image)){{ URL::asset('assets/images/fasyankes/'. $fasyankes->image) }}@else{{ URL::asset('assets/images/profile-bg-1.jpg') }}@endif"
                                    alt="" class="rounded me-2" width="200" data-holder-rendered="true">
                            </div>
                            <div class="text-danger" role="alert" id="imageError" data-ajax-feedback="image"></div>
                        </div>

                        <div class="mt-3 d-grid">
                            <button class="btn btn-primary waves-effect waves-light UpdateProfile"
                                data-id="{{ Auth::user()->id }}" type="submit">Simpan</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>

@section('script')
<script>
    window.addEventListener('openUpdateFasyankesModal', event => {
        $("#update-fasyankes").modal('show');
    })

    window.addEventListener('closeUpdateFasyankesModal', event => {
        $("#update-fasyankes").modal('hide');
    })
</script>
@endsection