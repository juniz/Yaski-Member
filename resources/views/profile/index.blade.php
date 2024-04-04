@extends('layouts.master')
@section('title') Profile @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/choices.js/choices.js.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
<!-- CSS -->
<link href="https://cdn.jsdelivr.net/npm/smartwizard@6/dist/css/smart_wizard_all.min.css" rel="stylesheet"
    type="text/css" />

<style>
    .required:after {
    content:"*\00a0";
    color:red;
}
</style>
@endsection
@section('content')
<div class="row">
    <div class="col-xl-12">
        @if(!empty($fasyankes->image))
        <div class="bg-image" style='
            background-image: url("{{ asset('storage/fasyankes/'.$fasyankes->image) }}");
            height: 50vh;background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            margin: -24px -24px 23px -24px;
            padding: 140px 0px;
            position: relative;
            '></div>
        @else
        <div class="bg-image" style='
            background-image: url("{{URL::asset('assets/images/auth-bg.jpg')}}"); height: 50vh;background-position:
            center; background-size: cover; background-repeat: no-repeat; margin: -24px -24px 23px -24px; padding: 140px
            0px; position: relative; '></div>
	@endif
    </div>
</div>

<div class=" row">
            <div class="profile-content">
                <div class="row align-items-end">
                    <div class="col-sm">
                        <div class="d-flex align-items-end mt-3 mt-sm-0">
                            <div class="flex-shrink-0">
                                <div class="avatar-xxl me-3">
                                    <img src="@if ($user->avatar != ''){{ asset('storage/avatar/'.$user->avatar) }}
            @else {{ URL::asset('storage/avatar/blank.png') }} @endif"
            alt="profile-image" class="img-fluid rounded-circle img-thumbnail"
            style="max-height: 8.5rem; width:7.2rem">
        </div>
    </div>
    <div class="flex-grow-1">
        <div>
            <h5 class="font-size-16 mb-1">
            @if(!empty($user->paklaring) && !empty($user->mou))
                @if($user->paklaring->stts == 'disetujui' && $user->mou->stts == 'disetujui')
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="blue" class="bi bi-patch-check-fill" viewBox="0 0 16 16">
                    <path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708"/>
                </svg>
                @endif
            @endif
             {{ $user->name }}
            </h5>
            <p class="text-muted font-size-13 mb-2 pb-2">{{ $user->email }}</p>
        </div>
    </div>
</div>
</div>
<div class="col-sm-auto">
    <div class="d-flex align-items-start justify-content-end gap-2 mb-2">
        <div>
            <div class="dropdown">
                <button class="btn btn-link font-size-16 shadow-none text-muted dropdown-toggle" type="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bx bx-dots-horizontal-rounded font-size-20"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target=".update-profile"
                            href="#">Profile</a></li>
                    <li><a class="dropdown-item" data-bs-toggle="modal" id="changePasswordBtn" data-bs-target="#changePasswordModal"
                                href="#">Rubah Password</a></li>
                    <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target=".update-fasyankes"
                            href="#">Fasyankes</a></li>
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
                <livewire:profile.tab-paklaring />
            </div>
        </div>
    </div>
</div>

<livewire:profile.alert :fasyankes="$fasyankes" />

<div class="row">
    <div class="col-xl-8 col-lg-8">
        <div class="tab-content">
            <div class="tab-pane active" id="overview" role="tabpanel">
                <livewire:profile.body />
            </div>
            <!-- end tab pane -->

            <div class="tab-pane" id="paklaring-tabpanel" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex flex-row justify-content-between">
                            <h4 class="card-title text-uppercase mb-0">Paklaring
                            </h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div wire:ignore.self class="accordion" id="accordionExample">
                            <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                1. Download Template Paklaring
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="container p-5">
                                        <div class="d-flex flex-row justify-content-center">
                                            {{-- <a href="{{ URL::asset('assets/files/template_paklaring.xlsx') }}" --}}
                                            <a href="{{ env('URL_PAKLARING') }}"
                                            class="btn btn-lg btn-secondary ms-2"><i class="bx bx-download"></i>
                                            Unduh Template</a>
                                        </div>
                                    </div>
                            </div>
                            </div>
                            <div class="accordion-item">
                              <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    2. Upload Paklaring
                                </button>
                              </h2>
                              <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <livewire:component.upload-paklaring />
                                </div>
                              </div>
                            </div>
                            <div class="accordion-item">
                              <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                  3. Paklaring
                                </button>
                              </h2>
                              <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <livewire:component.paklaring />
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card -->
                </div>                
            </div>
            <!-- end tab pane -->
            <div class="tab-pane" id="mou-tabpanel" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex flex-row justify-content-between">
                            <h4 class="card-title text-uppercase mb-0">MOU
                            </h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div wire:ignore.self class="accordion" id="accordionExample">
                            <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                1. Download Template MOU
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="container p-5">
                                        <div class="d-flex flex-row justify-content-center">
                                            {{-- <a href="{{ URL::asset('assets/files/template_paklaring.xlsx') }}" --}}
                                            <a href="{{ env('URL_PAKLARING') }}"
                                            class="btn btn-lg btn-secondary ms-2"><i class="bx bx-download"></i>
                                            Unduh Template</a>
                                        </div>
                                    </div>
                            </div>
                            </div>
                            <div class="accordion-item">
                              <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    2. Upload MOU
                                </button>
                              </h2>
                              <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <livewire:component.upload-mou />
                                </div>
                              </div>
                            </div>
                            <div class="accordion-item">
                              <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                  3. Status MOU
                                </button>
                              </h2>
                              <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <livewire:component.mou />
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="tab-pane" id="workshop-tabpanel" role="tabpanel">
                <livewire:profile.riwayat-workshop />
            </div>
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
                        <label for="avatar">Logo Instansi / Fasyankes</label>
                        <div class="input-group">
                            <input type="file" class="form-control @error('avatar') is-invalid @enderror" id="avatar"
                                name="avatar" autofocus>
                            <label class="input-group-text" for="avatar">Upload</label>
                        </div>
                        <div class="text-start mt-2">
                            <img src="@if (Auth::user()->avatar != ''){{ URL::asset('storage/avatar/'. Auth::user()->avatar) }}@else{{ URL::asset('assets/images/users/avatar-1.png') }}@endif"
                                alt="" class="rounded-circle avatar-lg">
                        </div>
                        <div class="text-danger" role="alert" id="avatarError" data-ajax-feedback="avatar">
                        </div>
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
                            class="form-control uppercase @error('kode') is-invalid @enderror" id='kode' name="kode" autofocus>
                        <div class="text-danger" id="kodeError" data-ajax-feedback="kode"></div>
                    </div>
                    <div class="mb-3">
                        <label class="required" for="nama">Nama Fasyankes</label>
                        <input type="text" value="{{$fasyankes->nama ?? ''}}" class=" form-control @error('nama') is-invalid
                @enderror" id='nama' name="nama">
                        <div class="text-danger" id="namaError" data-ajax-feedback="nama"></div>
                    </div>
                    <div class="mb-3">
                        <label for="jenis" class="form-label font-size-13 text-muted required">Jenis Fasyankes</label>
                        <select class="form-control @error('jenis') is-invalid @enderror" data-trigger name="jenis"
                            id="jenis" placeholder="Jenis Fasyankes">
                            <option value="">Pilih jenis</option>
                            @if($fasyankes)
                            @foreach($jenis as $j)
                            <option value="{{$j}}" @if($fasyankes->jenis == $j) selected @endif>{{$j}}</option>
                            @endforeach
                            @else
                            @foreach($jenis as $j)
                            <option value="{{$j}}">{{$j}}</option>
                            @endforeach
                            @endif
                        </select>
                        <div class="text-danger" id="jenisError" data-ajax-feedback="jenis"></div>
                    </div>

                    <div class="mb-3 kelas-form visually-hidden">
                        <label class="required" for="kelas">Kelas Fasyankes</label>
                        <select type="text" value="{{$fasyankes->kelas ?? ''}}"
                            class="form-control @error('kelas') is-invalid @enderror" data-trigger id='kelas'
                            name="kelas">
                            <option value="">Pilih kelas</option>
                            @if($fasyankes)
                            @foreach($kelas as $k)
                            <option value="{{$k}}" @if($fasyankes->kelas == $k) selected @endif>{{$k}}</option>
                            @endforeach
                            @else
                            @foreach($kelas as $k)
                            <option value="{{$k}}">{{$k}}</option>
                            @endforeach
                            @endif
                        </select>
                        <div class="text-danger" id="kelasError" data-ajax-feedback="kelas"></div>
                    </div>

                    <div class="mb-3">
                        <label class="required" for="telp">Telp</label>
                        <input type="text" value="{{$fasyankes->telp ?? ''}}"
                            class="form-control @error('telp') is-invalid @enderror" id='telp' name="telp">
                        <div class="text-danger" id="telpError" data-ajax-feedback="telp"></div>
                    </div>

                    <div class="mb-3">
                        <label class="required" for="email">Email</label>
                        <input type="email" value="{{$fasyankes->email ?? ''}}"
                            class="form-control @error('email') is-invalid @enderror" id='email' name="email">
                        <div class="text-danger" id="emailError" data-ajax-feedback="email"></div>
                    </div>

                    <div class="mb-3">
                        <label class="required" for="direktur">Nama Direktur / Kepala Rumah Sakit</label>
                        <input type="text" value="{{$fasyankes->direktur ?? ''}}" class="form-control @error('direktur') is-invalid
            @enderror" id='direktur' name="direktur">
                        <div class="text-danger" id="direkturError" data-ajax-feedback="telp"></div>
                    </div>

                    <div class="col-12">
                        <div class="mb-3">
                            <label for="provinsi" class="form-label font-size-13 text-muted required">Provinsi</label>
                            <select class="form-control" name="provinsi" id="provinsi"
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
                            <label for="kabupaten" class="form-label font-size-13 text-muted required">Kabupaten /
                                Kota</label>
                            <select class="form-control" name="kabupaten" id="kabupaten" placeholder="Cari Kabupaten">
                            </select>
                            <div class="text-danger" id="kabupatenError" data-ajax-feedback="kabupaten"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="required">Alamat Fasyankes</label>
                        <textarea type="text" class="form-control @error('alamat') is-invalid @enderror" id='alamat'
                            name="alamat" cols="3">{{$fasyankes->alamat ?? ''}}</textarea>
                        <div class="text-danger" id="alamatError" data-ajax-feedback="alamat"></div>
                    </div>

                    <div class="mb-3">
                        <label for="image">Gambar tampak depan Fasyankes <small class="text-danger">File gambar max 1mb</small></label>
                        <div class="input-group">
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                                name="image" autofocus>
                            <label class="input-group-text" for="image">Upload</label>
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

<livewire:profile.daftar-workshop />
<livewire:component.change-password />

@endsection
@section('script')
<script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/sweetalert.init.js') }}"></script>
<script src="{{ URL::asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/choices.js/choices.js.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/profile.init.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script src="{{ env('URL_SNAP') }}" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script type="text/javascript">
    // $('#smartwizard').smartWizard({
    //     theme: 'arrows',
    //     lang: {
    //         next: 'Selanjutnya',
    //         previous: 'Sebelumnya'
    //     }
    // });

    $('#changePasswordBtn').on('click', function() {
        $('#changePasswordModal').modal('show');
    });

    $('#jenis').on('change', function() {
        var jenis = $(this).val();
        if (jenis == 'Rumah Sakit') {
            $('.kelas-form').removeClass('visually-hidden');
        } else {
            $('.kelas-form').addClass('visually-hidden');
        }
    });

    
    $("#btn-unggah-paklaring").on('click', function() {
        Livewire.emit('refreshPaklaring');
        $('.update-paklaring').modal('show');
    });

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
                    console.log(response);
                    alert(response.Message);
                } else if (response.isSuccess == true) {
                    $('.update-fasyankes').modal('hide');
                    // livewire.emit('load-fasyankes');
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

    const provinsi = new Choices('#provinsi', {
        removeItemButton: true,
        searchPlaceholderValue: 'Cari Provinsi', 
        placeholder: false,
    });

    const query_task = new Choices('#kabupaten', {
            removeItemButton: true,
            searchPlaceholderValue: 'Pilih Kabupaten / Kota', 
            placeholder: false,
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
            $('.tambah-team').modal('hide');
            Livewire.emit('getTeam');
        })

        window.addEventListener('confirmDelete', e => {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Anda tidak dapat mengembalikan data yang telah dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#536de6',
                cancelButtonColor: '#f46a6a',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('deleteTeam', e.detail.id);
                }
            })
        })

        window.addEventListener('message', e => {
            Swal.fire(
                e.detail.title,
                e.detail.message,
                e.detail.type
            ).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit(e.detail.event);
                }
            })
        })

    Livewire.on('openModalEditTeam', () => {
        $('.edit-team-modal').modal('show');
    })

    Livewire.on('closeModalEditTeam', () => {

        $('.edit-team-modal').modal('hide');
    })

    Livewire.on('openModalSkpic', () => {
        $('.skpic-team-modal').modal('show');
    })

    Livewire.on('open-modal-workshop', () => {
        $('.daftar-workshop-modal').modal('show');
    })

    Livewire.on('open-modal-snap', (event) => {
        // console.log(event);
        snap.pay(event.snapToken, {
            onSuccess: function(result) {
                console.log(result);
                Livewire.emit('updateSnapToken', event.order_id, event.snapToken);
            },
            onPending: function(result) {
                console.log(result);
                // Livewire.emit('batalDaftar', event.id);
            },
            onError: function(result) {
                alert(result.status_message);
                // Livewire.emit('batalDaftar', event.id);
            }
        });
    })

    Livewire.on('close-modal-workshop', () => {
        $('.daftar-workshop-modal').modal('hide');
    })
</script>
@endsection