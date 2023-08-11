@extends('layouts.master')
@section('title') @lang('translation.User_Grid') @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Contacts @endslot
@slot('title') User Grid @endslot
@endcomponent
<livewire:profile.gride-members />
@endsection
@section('script')
<script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/sweetalert.init.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script>
    window.addEventListener('modalPakelaring', event => {
        $('#pakelaring-modal').modal('show');
    })
    window.addEventListener('closeModalPakelaring', event => {
        $('#pakelaring-modal').modal('hide');
    })
</script>
@endsection