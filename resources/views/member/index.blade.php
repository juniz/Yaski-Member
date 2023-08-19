@extends('layouts.master')
@section('title') @lang('translation.User_Grid') @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Contacts @endslot
@slot('title') User Grid @endslot
@endcomponent
<livewire:profile.gride-members />
<livewire:profile.create-user />
<livewire:profile.edit-user />
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
    window.addEventListener('openModalUser', event => {
        $('.tambah-user').modal('show');
    })
    window.addEventListener('closeModalUser', event => {
        $('.tambah-user').modal('hide');
    })
    window.addEventListener('openModalEditUser', event => {
        $('.edit-user').modal('show');
    })
    window.addEventListener('closeModalEditUser', event => {
        $('.edit-user').modal('hide');
    })
</script>
@endsection