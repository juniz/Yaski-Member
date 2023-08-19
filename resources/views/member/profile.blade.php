@extends('layouts.master')
@section('title') @lang('translation.Profile') @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/choices.js/choices.js.min.css') }}" rel="stylesheet">
{{-- <style>
    .profile-users {
        background-image: url('{{URL::asset("assets/images/fasyankes/".$fasyankes->image ?? "-")}}');
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
</style> --}}
@endsection
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="profile-users bg-white" style="height: 300px">
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
                            <img src="@if ($user->avatar != ''){{ URL::asset('storage/'. $user->avatar) }} @else {{ URL::asset('assets/images/users/avatar-1.png') }} @endif"
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
            {{-- <div class="col-sm-auto">
                <div class="d-flex align-items-start justify-content-end gap-2 mb-2">
                    <div>
                        <button type="button" class="btn btn-success"><i class="me-1"></i> Message</button>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target=".update-profile"><i class="me-1"></i> Ubah Profile</button>

                    </div>
                    <div>
                        <div class="dropdown">
                            <button class="btn btn-link font-size-16 shadow-none text-muted dropdown-toggle"
                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bx bx-dots-horizontal-rounded font-size-20"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div> --}}
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
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex flex-row justify-content-between">
                            <h4 class="card-title text-uppercase mb-0">{{ $fasyankes->nama ?? 'Data Fasyankes Kosong' }}
                            </h4>
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
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target=".update-paklaring"><i class="bx bx-plus me-1"></i>@if(empty($paklaring))
                                Tambah Paklaring @else Ubah
                                Paklaring @endif</button>
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

        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-row justify-content-between">
                    <h5 class="card-title mb-0">Team Members</h5>
                </div>

            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle table-nowrap">
                        <tbody>
                            @foreach ($subUsers as $subUser)
                            <tr>

                                <td style="width: 50px;"><img src="{{ URL::asset('images/avatar/'. $subUser->avatar) }}"
                                        class="rounded-circle avatar-sm" alt=""></td>
                                <td>
                                    <h5 class="font-size-14 m-0"><a href="javascript: void(0);" class="text-dark">{{
                                            $subUser->name }}</a></h5>
                                </td>
                                <td>
                                    <div>
                                        <a href="javascript: void(0);"
                                            class="badge bg-soft-primary text-primary font-size-11">Frontend</a>
                                        <a href="javascript: void(0);"
                                            class="badge bg-soft-primary text-primary font-size-11">UI</a>
                                    </div>
                                </td>
                                <td>
                                    <i class="mdi mdi-circle-medium font-size-18 text-success align-middle me-1"></i>
                                    Online
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- end col -->
</div>
<!-- end row -->

@endsection
@section('script')
<script src="{{ URL::asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/choices.js/choices.js.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/profile.init.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection