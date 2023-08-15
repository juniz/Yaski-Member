@extends('layouts.master')
@section('title') @lang('translation.Profile') @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/choices.js/choices.js.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
<style>
    .profile-users {
        background-image: url('{{URL::asset("assets/images/fasyankes/".$fasyankes->image)}}');
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
        margin: -24px -24px 23px -24px;
        padding: 140px 0px;
        position: relative;
    }

    .profile-users:after {
        background: -webkit-gradient(linear, left top, left bottom, color-stop(30%, rgba(43, 57, 64, 0.5)), to(#2b3940));
        background: linear-gradient(to bottom, rgba(43, 57, 64, 0.5) 30%, #2b3940 100%);
        position: absolute;
        height: 100%;
        width: 100%;
        right: 0;
        bottom: 0;
        left: 0;
        top: 0;
        opacity: 0.5;
        content: "";
    }
</style>
@endsection
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="profile-users" style="height: 300px">
        </div>
    </div>
</div>

<div class="row">
    <div class="profile-content">
        <div class="row align-items-end">
            <div class="col-sm">
                <div class="d-flex align-items-end mt-3 mt-sm-0">
                    <div class="flex-shrink-0">
                        <div class="avatar-xxl me-3">
                            <img src="@if ($user->avatar != ''){{ URL::asset('images/'. $user->avatar) }} @else {{ URL::asset('assets/images/users/avatar-1.png') }} @endif"
                                alt="profile-image" class="img-fluid rounded-circle img-thumbnail"
                                style="max-height: 8.5rem; width:7.2rem">
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <div>
                            <h5 class="font-size-16 mb-1">{{ $user->name }}</h5>
                            <p class="text-muted font-size-13 mb-2 pb-2">{{ $user->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-auto">
                <div class="d-flex align-items-start justify-content-end gap-2 mb-2">
                    {{-- <div>
                        <button type="button" class="btn btn-success"><i class="me-1"></i> Message</button>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target=".update-profile"><i class="me-1"></i> Ubah Profile</button>

                    </div> --}}
                    <div>
                        <div class="dropdown">
                            <button class="btn btn-link font-size-16 shadow-none text-muted dropdown-toggle"
                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bx bx-dots-horizontal-rounded font-size-20"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target=".update-profile"
                                        href="#">Profile</a></li>
                                <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target=".update-fasyankes"
                                        href="#">Fasyankes</a></li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card bg-transparent shadow-none">
            <div class="card-body">
                <ul class="nav nav-tabs-custom card-header-tabs border-top mt-2" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link px-3 active" data-bs-toggle="tab" href="#overview" role="tab">Profile
                            Fasyankes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3" data-bs-toggle="tab" href="#post" role="tab">Pakelaring</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-8 col-lg-8">
        <div class="tab-content">
            <div class="tab-pane active" id="overview" role="tabpanel">
                {{--
                <livewire:profile.body /> --}}
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex flex-row justify-content-between">
                            <h4 class="card-title text-uppercase mb-0">{{ $fasyankes->nama ?? 'Data Fasyankes Kosong' }}
                            </h4>
                            {{-- <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target=".update-fasyankes"><i class="bx bx-plus me-1"></i>@if(empty($fasyankes))
                                Tambah Fasyankes @else Ubah
                                Fasyankes @endif</button> --}}
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
            </div>
            <!-- end tab pane -->

            <div class="tab-pane" id="post" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex flex-row justify-content-between">
                            <h4 class="card-title text-uppercase mb-0">Paklaring
                            </h4>
                            {{-- <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target=".update-paklaring"><i class="bx bx-plus me-1"></i>@if(empty($paklaring))
                                Tambah Paklaring @else Ubah
                                Paklaring @endif</button> --}}
                        </div>
                    </div>
                    <div class="card-body">
                        @if(empty($paklaring))
                        <h6 class="text-center">Data Kosong</h6>
                        @else
                        <iframe src="{{ URL::asset('assets/files/paklaring/'. $paklaring->file) }}" frameborder="0"
                            width="300vw" height="500vh"></iframe>
                        @endif
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
            <!-- end tab pane -->
        </div>
        <!-- end tab content -->
    </div>
    <!-- end col -->

    <div class="col-xl-4 col-lg-4">

        <livewire:profile.member :user="$user" />
    </div>
    <!-- end col -->
</div>
<!-- end row -->
<!--  Update Profile example -->
<div class="modal fade update-profile" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Ubah Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" enctype="multipart/form-data" id="update-profile">
                    @csrf
                    <input type="hidden" value="{{ Auth::user()->id }}" id="data_id">
                    <div class="mb-3">
                        <label for="useremail" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="useremail"
                            value="{{ Auth::user()->email }}" name="email" placeholder="Enter email" autofocus>
                        <div class="text-danger" id="emailError" data-ajax-feedback="email"></div>
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            value="{{ Auth::user()->name }}" id="username" name="name" autofocus
                            placeholder="Enter username">
                        <div class="text-danger" id="nameError" data-ajax-feedback="name"></div>
                    </div>
                    <div class="mb-3">
                        <label for="avatar">Profile Picture</label>
                        <div class="input-group">
                            <input type="file" class="form-control @error('avatar') is-invalid @enderror" id="avatar"
                                name="avatar" autofocus>
                            <label class="input-group-text" for="avatar">Upload</label>
                        </div>
                        <div class="text-start mt-2">
                            <img src="@if (Auth::user()->avatar != ''){{ URL::asset('images/'. Auth::user()->avatar) }}@else{{ URL::asset('assets/images/users/avatar-1.png') }}@endif"
                                alt="" class="rounded-circle avatar-lg">
                        </div>
                        <div class="text-danger" role="alert" id="avatarError" data-ajax-feedback="avatar"></div>
                    </div>

                    <div class="mt-3 d-grid">
                        <button class="btn btn-primary waves-effect waves-light UpdateProfile"
                            data-id="{{ Auth::user()->id }}" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

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
                            class="form-control @error('kode') is-invalid @enderror" id='kode' name="kode" autofocus>
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
                            <select class="form-control" name="kabupaten" id="kabupaten" placeholder="Cari Kabupaten">
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

<!--  Update Profile example -->
<div class="modal fade update-paklaring" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Paklaring</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" enctype="multipart/form-data" id="update-paklaring">
                    @csrf
                    <input type="hidden" value="{{ Auth::user()->id }}" id="data_id">
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal"
                            value="{{ $paklaring->tgl_pakai ?? '' }}" name="tanggal" placeholder="Enter tanggal"
                            autofocus>
                        <div class="text-danger" id="tanggalError" data-ajax-feedback="tanggal"></div>
                    </div>

                    <div class="mb-3">
                        <label for="file">Dokumen paklaring</label>
                        <div class="input-group">
                            <input type="file" class="form-control @error('dokumen') is-invalid @enderror" id="dokumen"
                                name="dokumen" autofocus>
                            <label class="input-group-text" for="dokumen">Upload</label>
                        </div>
                        <div class="text-danger" role="alert" id="dokumenError" data-ajax-feedback="dokumen"></div>
                    </div>

                    <div class="mt-3 d-grid">
                        <button class="btn btn-primary waves-effect waves-light UpdatePaklaring"
                            data-id="{{ Auth::user()->id }}" type="submit">Unggah</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection
@section('script')
<script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/sweetalert.init.js') }}"></script>
<script src="{{ URL::asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/choices.js/choices.js.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/profile.init.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script type="text/javascript">
    function hapusTeam(id){
        
    }

    $('#update-profile').on('submit', function(event) {
        event.preventDefault();
        var Id = $('#data_id').val();
        let formData = new FormData(this);
        $('#emailError').text('');
        $('#nameError').text('');
        $('#avatarError').text('');
        $.ajax({
            url: "{{ url('update-profile') }}" + "/" + Id,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#emailError').text('');
                $('#nameError').text('');
                $('#avatarError').text('');
                if (response.isSuccess == false) {
                    alert(response.Message);
                } else if (response.isSuccess == true) {
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                }
            },
            error: function(response) {
                $('#emailError').text(response.responseJSON.errors.email);
                $('#nameError').text(response.responseJSON.errors.name);
                $('#avatarError').text(response.responseJSON.errors.avatar);
            }
        });
    });

    $('#tambah-team').on('submit', function(event) {
        event.preventDefault();
        var Id = $('#data_id').val();
        let formData = new FormData(this);
        $('#emailTeamError').text('');
        $('#nameTeamError').text('');
        $('#avatarTeamError').text('');
        $.ajax({
            url: "{{ url('update-team') }}" + "/" + Id,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#emailTeamError').text('');
                $('#nameTeamError').text('');
                $('#avatarTeamError').text('');
                if (response.isSuccess == false) {
                    alert(response.Message);
                } else if (response.isSuccess == true) {
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                }
            },
            error: function(response) {
                $('#emailTeamError').text(response.responseJSON.errors.emailTeam);
                $('#nameTeamError').text(response.responseJSON.errors.nameTeam);
                $('#avatarTeamError').text(response.responseJSON.errors.avatarTeam);
            }
        });
    });

    $('#update-paklaring').on('submit', function(event) {
        event.preventDefault();
        var Id = $('#data_id').val();
        let formData = new FormData(this);
        $('#tanggalError').text('');
        $('#dokumenError').text('');
        $.ajax({
            url: "{{ url('update-paklaring') }}" + "/" + Id,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#tanggalError').text('');
                $('#dokumenError').text('');
                if (response.isSuccess == false) {
                    alert(response.Message);
                } else if (response.isSuccess == true) {
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                }
            },
            error: function(response) {
                // console.log(response);
                $('#tanggalError').text(response.responseJSON.errors.tanggal);
                $('#dokumenError').text(response.responseJSON.errors.dokumen);
            }
        });
    });

    $('#update-fasyankes').on('submit', function(event) {
        event.preventDefault();
        var Id = $('#data_id').val();
        let formData = new FormData(this);
        $('#kodeError').text('');
        $('#namaError').text('');
        $('#jenisError').text('');
        $('#kelasError').text('');
        $('#telpError').text('');
        $('#emailError').text('');
        $('#direkturError').text('');
        $('#alamatError').text('');
        $('#provinsiError').text('');
        $('#kabupatenError').text('');
        $('#imageError').text('');
        $.ajax({
            url: "{{ url('update-fasyankes') }}" + "/" + Id,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.isSuccess == false) {
                    alert(response.Message);
                } else if (response.isSuccess == true) {
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                }
            },
            error: function(response) {
                $('#nameError').text(response.responseJSON.errors.name);
                $('#kodeError').text(response.responseJSON.errors.kode);
                $('#jenisError').text(response.responseJSON.errors.jenis);
                $('#kelasError').text(response.responseJSON.errors.kelas);
                $('#telpError').text(response.responseJSON.errors.telp);
                $('#emailError').text(response.responseJSON.errors.email);
                $('#direkturError').text(response.responseJSON.errors.direktur);
                $('#alamatError').text(response.responseJSON.errors.alamat);
                $('#provinsiError').text(response.responseJSON.errors.provinsi);
                $('#kabupatenError').text(response.responseJSON.errors.kabupaten);
                $('#imageError').text(response.responseJSON.errors.image);
            }
        });
    });

    const query_task = new Choices('#kabupaten', {
            removeItemButton: true,
            searchPlaceholderValue: 'Pilih Kabupaten / Kota', 
            placeholder: true,
        });
        query_task.passedElement.element.addEventListener('addItem', () => reset(), false);
        query_task.passedElement.element.addEventListener('removeItem', () => reset(), false);

        function reset(id) {
            query_task.clearChoices();
            query_task.setChoices(function() { 
                return fetch( 
                    "{{ url('get-kabupaten') }}" + "/" + id
                ) 
                .then(function(response) { 
                    return response.json(); 
                }) 
                .then(function(data) { 
                    return data.map(function(response) { 
                        return { label: response.name, value: response.id }; 
                    }); 
                }); 
            });
        }

        $("#provinsi").on('change', function() {
            let id = $(this).val();
            query_task.removeActiveItems();
            reset(id);
        });

        window.addEventListener('openModalTeam', e => {
            $('.tambah-team').modal('show');
        })

        window.addEventListener('closeModalTeam', e => {
            $('.tambah-team').modal('hide').then(function() {
                
            });
        })
</script>
@endsection