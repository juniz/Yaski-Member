@extends('layouts.master-without-nav')
@section('title')
Login
@endsection
@section('content')

<div class="auth-page">
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-xxl-4 col-lg-4 col-md-5">
                <div class="auth-full-page-content d-flex p-sm-5 p-4">
                    <div class="w-100">
                        <div class="d-flex flex-column h-100">
                            <div class="mb-4 mb-md-5 text-center">
                                <a href="{{ url('/') }}" class="d-block auth-logo">
                                    <img src="{{ URL::asset('assets/images/logo.png') }}" alt="" height="50"> <span
                                        class="logo-txt">YASKI</span>
                                </a>
                            </div>
                            <div class="auth-content my-auto">
                                <div class="text-center">
                                    <h5 class="mb-0">Selamat Datang</h5>
                                </div>
                                <form class="mt-4 pt-2" action="{{ route('login') }}" method="POST">
                                    @csrf
                                    <div class="form-floating form-floating-custom mb-4">
                                        <input type="text" class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email') }}" id="input-username" placeholder="Enter User Name"
                                            name="email">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        <label for="input-username">Username</label>
                                        <div class="form-floating-icon">
                                            <i data-feather="mail"></i>
                                        </div>
                                    </div>

                                    <div class="form-floating form-floating-custom mb-4 auth-pass-inputgroup">
                                        <input type="password"
                                            class="form-control pe-5 @error('password') is-invalid @enderror"
                                            name="password" id="password-input" placeholder="Enter Password">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        <button type="button" class="btn btn-link position-absolute h-100 end-0 top-0"
                                            id="password-addon">
                                            <i class="mdi mdi-eye-outline font-size-18 text-muted"></i>
                                        </button>
                                        <label for="input-password">Password</label>
                                        <div class="form-floating-icon">
                                            <i data-feather="lock"></i>
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col">
                                            <div class="form-check font-size-15">
                                                <input class="form-check-input " type="checkbox" id="remember-check">
                                                <label class="form-check-label font-size-13" for="remember-check">
                                                    Ingat saya
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="mb-3">
                                        <button class="btn btn-primary w-100 waves-effect waves-light"
                                            type="submit">Masuk</button>
                                    </div>
                                </form>

                                {{-- <div class="mt-4 pt-2 text-center">
                                    <div class="signin-other-title">
                                        <h5 class="font-size-14 mb-3 text-muted fw-medium">- Sign in with -</h5>
                                    </div>

                                    <ul class="list-inline mb-0">
                                        <li class="list-inline-item">
                                            <a href="javascript:void()"
                                                class="social-list-item bg-primary text-white border-primary">
                                                <i class="mdi mdi-facebook"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript:void()"
                                                class="social-list-item bg-info text-white border-info">
                                                <i class="mdi mdi-twitter"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript:void()"
                                                class="social-list-item bg-danger text-white border-danger">
                                                <i class="mdi mdi-google"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div> --}}

                                <div class="mt-5 text-center">
                                    <p class="text-muted mb-0">Belum punya akun ? <a href="{{ url('register') }}"
                                            class="text-primary fw-semibold"> Daftar sekarang </a> </p>
                                </div>
                                <div class="mt-5 text-center">
                                <p class="text-muted mb-0"><a href="{{ url('/password/reset') }}"
                                            class="text-primary fw-semibold"> Lupa Password? </a> </p>
                                </div>
                            </div>
                            <div class="mt-4 mt-md-5 text-center">
                                {{-- <p class="mb-0">© <script>
                                        document.write(new Date().getFullYear())
                                    </script> Dason . Crafted with <i class="mdi mdi-heart text-danger"></i> by
                                    Themesdesign</p> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end auth full page content -->
            </div>
            <!-- end col -->
            <div class="col-xxl-8 col-lg-8 col-md-7">
                <div class="auth-bg pt-md-5 p-4 d-flex">
                    <div class="bg-overlay"></div>
                    <ul class="bg-bubbles">
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                    </ul>
                    <!-- end bubble effect -->
                    {{-- <div class="row justify-content-center align-items-end">
                        <div class="col-xl-12">
                            <div class="p-0 p-sm-4 px-xl-0">
                                <div id="reviewcarouselIndicators" class="carousel slide" data-bs-ride="carousel">
                                    <div
                                        class="carousel-indicators auth-carousel carousel-indicators-rounded justify-content-center mb-0">
                                        <button type="button" data-bs-target="#reviewcarouselIndicators"
                                            data-bs-slide-to="0" class="active" aria-current="true"
                                            aria-label="Slide 1">
                                            <img src="{{ URL::asset('assets/images/pengurus/mas-win.jpg') }}"
                                                class="avatar-md img-fluid rounded-circle d-block" alt="...">
                                        </button>
                                        <button type="button" data-bs-target="#reviewcarouselIndicators"
                                            data-bs-slide-to="1" aria-label="Slide 2">
                                            <img src="{{ URL::asset('assets/images/pengurus/kusmanto.jpg') }}"
                                                class="avatar-md img-fluid rounded-circle d-block" alt="...">
                                        </button>
                                        <button type="button" data-bs-target="#reviewcarouselIndicators"
                                            data-bs-slide-to="2" aria-label="Slide 3">
                                            <img src="{{ URL::asset('assets/images/pengurus/adri.jpeg') }}"
                                                class="avatar-md img-fluid rounded-circle d-block" alt="...">
                                        </button>
                                        <button type="button" data-bs-target="#reviewcarouselIndicators"
                                            data-bs-slide-to="3" aria-label="Slide 4">
                                            <img src="{{ URL::asset('assets/images/pengurus/salim.jpg') }}"
                                                class="avatar-md img-fluid rounded-circle d-block" alt="...">
                                        </button>
                                        <button type="button" data-bs-target="#reviewcarouselIndicators"
                                            data-bs-slide-to="4" aria-label="Slide 5">
                                            <img src="{{ URL::asset('assets/images/pengurus/agus.jpg') }}"
                                                class="avatar-md img-fluid rounded-circle d-block" alt="...">
                                        </button>
                                        <button type="button" data-bs-target="#reviewcarouselIndicators"
                                            data-bs-slide-to="5" aria-label="Slide 6">
                                            <img src="{{ URL::asset('assets/images/pengurus/driful.jpeg') }}"
                                                class="avatar-md img-fluid rounded-circle d-block" alt="...">
                                        </button>
                                        <button type="button" data-bs-target="#reviewcarouselIndicators"
                                            data-bs-slide-to="6" aria-label="Slide 7">
                                            <img src="{{ URL::asset('assets/images/pengurus/haris.jpg') }}"
                                                class="avatar-md img-fluid rounded-circle d-block" alt="...">
                                        </button>
                                        <button type="button" data-bs-target="#reviewcarouselIndicators"
                                            data-bs-slide-to="7" aria-label="Slide 8">
                                            <img src="{{ URL::asset('assets/images/pengurus/pakedy.jpg') }}"
                                                class="avatar-md img-fluid rounded-circle d-block" alt="...">
                                        </button>
                                    </div>
                                    <!-- end carouselIndicators -->
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <div class="testi-contain text-center text-white">
                                                <h4 class="mt-4 fw-medium lh-base text-white">“Pengembang Utama,
                                                    Pemilik, Pemegang HAKI SIMKES Khanza.”
                                                </h4>
                                                <div class="mt-4 pt-1 pb-5 mb-5">
                                                    <h5 class="font-size-16 text-white">Windiarto
                                                    </h5>
                                                    <p class="mb-0 text-white-50">Pengembang SIMKES Khanza</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="carousel-item">
                                            <div class="testi-contain text-center text-white">
                                                <i class="bx bxs-quote-alt-left text-success display-6"></i>
                                                <h4 class="mt-4 fw-medium lh-base text-white">“Ketua Yayasan SIMRS Khanza Indonesia.”</h4>
                                                <div class="mt-4 pt-1 pb-5 mb-5">
                                                    <h5 class="font-size-16 text-white">Kusmanto Lesmana
                                                    </h5>
                                                    <p class="mb-0 text-white-50">Ketua</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="carousel-item">
                                            <div class="testi-contain text-center text-white">
                                                <i class="bx bxs-quote-alt-left text-success display-6"></i>
                                                <h4 class="mt-4 fw-medium lh-base text-white">"Wakil Ketua Yayasan SIMRS Khanza Indonesia RS Simpangan Depok.</h4>
                                                <div class="mt-4 pt-1 pb-5 mb-5">
                                                    <h5 class="font-size-16 text-white">Andri Cahyo W</h5>
                                                    <p class="mb-0 text-white-50">Wakil Ketua
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="carousel-item">
                                            <div class="testi-contain text-center text-white">
                                                <i class="bx bxs-quote-alt-left text-success display-6"></i>
                                                <h4 class="mt-4 fw-medium lh-base text-white">"Pengawas Yayasan SIMRS Khanza Indonesia."</h4>
                                                <div class="mt-4 pt-1 pb-5 mb-5">
                                                    <h5 class="font-size-16 text-white">dr. Salim Mulyana</h5>
                                                    <p class="mb-0 text-white-50">Dokumenter
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="carousel-item">
                                            <div class="testi-contain text-center text-white">
                                                <i class="bx bxs-quote-alt-left text-success display-6"></i>
                                                <h4 class="mt-4 fw-medium lh-base text-white">"Pembina Yayasan SIMRS Khanza Indonesia."</h4>
                                                <div class="mt-4 pt-1 pb-5 mb-5">
                                                    <h5 class="font-size-16 text-white">Agus Budiono</h5>
                                                    <p class="mb-0 text-white-50">Pembina
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="carousel-item">
                                            <div class="testi-contain text-center text-white">
                                                <i class="bx bxs-quote-alt-left text-success display-6"></i>
                                                <h4 class="mt-4 fw-medium lh-base text-white">"Sekretaris Yayasan SIMRS Khanza Indonesia."</h4>
                                                <div class="mt-4 pt-1 pb-5 mb-5">
                                                    <h5 class="font-size-16 text-white">dr. Saiful Umam</h5>
                                                    <p class="mb-0 text-white-50">Sekretaris
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="carousel-item">
                                            <div class="testi-contain text-center text-white">
                                                <i class="bx bxs-quote-alt-left text-success display-6"></i>
                                                <h4 class="mt-4 fw-medium lh-base text-white">"Admin Yayasan SIMRS Khanza Indonesia."</h4>
                                                <div class="mt-4 pt-1 pb-5 mb-5">
                                                    <h5 class="font-size-16 text-white">Haris Rochmatullah</h5>
                                                    <p class="mb-0 text-white-50">Admin
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="carousel-item">
                                            <div class="testi-contain text-center text-white">
                                                <i class="bx bxs-quote-alt-left text-success display-6"></i>
                                                <h4 class="mt-4 fw-medium lh-base text-white">"Humas Yayasan SIMRS Khanza Indonesia."</h4>
                                                <div class="mt-4 pt-1 pb-5 mb-5">
                                                    <h5 class="font-size-16 text-white">Edy Suprayitno</h5>
                                                    <p class="mb-0 text-white-50">Humas
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end carousel-inner -->
                                </div>
                                <!-- end review carousel -->
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container fluid -->
</div>
@endsection
@section('script')
<script src="{{ URL::asset('assets/js/pages/pass-addon.init.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/feather-icon.init.js') }}"></script>
@endsection