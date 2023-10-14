@extends('layouts.master')
@section('title') Paklaring @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Menu @endslot
@slot('title') Paklaring @endslot
@endcomponent
<livewire:paklaring.table />
<livewire:paklaring.persetujuan />
@endsection
@section('script')
<script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/sweetalert.init.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script>
    window.addEventListener('modalPersetujuan', event => {
        $('#persetujuan-modal').modal('show');
    })
    window.addEventListener('simpanPersetujuan', event => {
        $('#setuju-modal').modal('hide');
    })
    window.addEventListener('tolakPersetujuan', event => {
        $('#tolak-modal').modal('hide');
    })
    window.addEventListener('docPersetujuan', event => {
        $('#doc-persetujuan-modal').modal('show');
    })
</script>
@endsection