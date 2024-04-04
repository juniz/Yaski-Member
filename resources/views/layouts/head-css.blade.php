@yield('css')

<!-- preloader css -->
<link rel="stylesheet" href="{{ URL::asset('assets/css/preloader.min.css') }}" type="text/css" />

<!-- Bootstrap Css -->
<link href="{{ URL::asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
<!-- Icons Css -->
<link href="{{ URL::asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
<!-- App Css-->
<link href="{{ URL::asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

<link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<style>
    .uppercase {
        text-transform: uppercase;
    }

    .lowercase {
        text-transform: lowercase;
    }

    .capitalize {
        text-transform: capitalize;
    }
</style>