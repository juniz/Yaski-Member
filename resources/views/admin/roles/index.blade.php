@extends('layouts.master')
@section('title') Roles @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/choices.js/choices.js.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="card">
    <div class="card-body">
        <livewire:admin.roles.table />
        <livewire:admin.roles.create />
        <livewire:admin.roles.update />
        <livewire:admin.roles.add-user />
        <livewire:admin.roles.add-permission />
    </div>
</div>
@endsection
@section('script')
<script src="{{ URL::asset('assets/libs/choices.js/choices.js.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script>
    window.addEventListener('openModalRole', e => {
        $('.tambah-role').modal('show');
    })

    window.addEventListener('openModalUpdateRole', e => {
        $('.update-role').modal('show');
    })

    window.addEventListener('openModalUser', e => {
        $('.tambah-user').modal('show');
    })

    window.addEventListener('openModalPermission', e => {
        $('.tambah-permission').modal('show');
    })

    window.addEventListener('closeModalRole', e => {
        $('.tambah-role').modal('hide');
    })

    window.addEventListener('closeModalUpdateRole', e => {
        $('.update-role').modal('hide');
    })

    window.addEventListener('closeModalUser', e => {
        $('.tambah-user').modal('hide');
    })

    window.addEventListener('closeModalPermission', e => {
        $('.tambah-permission').modal('hide');
    })
</script>
@endsection