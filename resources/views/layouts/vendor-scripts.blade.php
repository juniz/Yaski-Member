<!-- JAVASCRIPT -->
@livewireScripts
<script src="{{ URL::asset('/assets/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/bootstrap/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/metismenu/metismenu.min.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/node-waves/node-waves.min.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/feather-icons/feather-icons.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/alert.init.js') }}"></script>
<script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/sweetalert.init.js') }}"></script>
<!-- pace js -->
<script src="{{ URL::asset('assets/libs/pace-js/pace-js.min.js') }}"></script>
<script src="{{ asset('vendor/livewire-alert/livewire-alert.js') }}"></script>
<!-- JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/smartwizard@6/dist/js/jquery.smartWizard.min.js" type="text/javascript">
</script>
<x-livewire-alert::scripts />
<x-livewire-alert::flash />
<script>
    window.addEventListener('swal', event => {
        Swal.fire({
            title: event.detail.title,
            text: event.detail.text,
            icon: event.detail.type,
            confirmButtonText: event.detail.confirmButtonText ?? 'Ok'
        })
    })
</script>
@yield('script')
@yield('script-bottom')