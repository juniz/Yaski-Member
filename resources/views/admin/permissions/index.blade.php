@extends('layouts.master')
@section('title') Permissions @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/choices.js/choices.js.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="card">
    <div class="card-body">
        <livewire:admin.permissions.table />
        <livewire:admin.permissions.create />
        <livewire:admin.permissions.update />
    </div>
</div>
@endsection
@section('script')
<script src="{{ URL::asset('assets/libs/choices.js/choices.js.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script>
    window.addEventListener('openModalPermission', e => {
        $('.tambah-permission').modal('show');
    })

    window.addEventListener('openModalUpdatePermission', e => {
        $('.update-permission').modal('show');
    })

    window.addEventListener('closeModalPermission', e => {
        $('.tambah-permission').modal('hide');
    })

    window.addEventListener('closeModalUpdatePermission', e => {
        $('.update-permission').modal('hide');
    })
</script>
@endsection