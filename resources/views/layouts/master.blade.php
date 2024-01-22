<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title> @yield('title') | Yaski Member</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Yaski Member" name="description" />
    <meta content="yaski" name="author" />
    @livewireStyles
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.ico') }}">
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @include('layouts.head-css')
</head>

@section('body')
@include('layouts.body')
@show
<!-- Begin page -->
<div id="layout-wrapper">
    @if(Auth::check())
    @include('layouts.topbar')
    @include('layouts.sidebar')
    @else
    @include('layouts.horizontal')
    @endif
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                @yield('content')
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
        @include('layouts.footer')
    </div>
    <!-- end main content-->
</div>
<!-- END layout-wrapper -->

<!-- Right Sidebar -->
@include('layouts.right-sidebar')
<!-- /Right-bar -->
<!-- JAVASCRIPT -->
@include('layouts.vendor-scripts')
</body>

</html>