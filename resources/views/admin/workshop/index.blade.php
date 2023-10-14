@extends('layouts.master')

@section('title')
@lang('translation.Starter_Page')
@endsection
@section('css')
<link href="{{ URL::asset('assets/libs/glightbox/glightbox.min.css') }}" rel="stylesheet">
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Admin @endslot
@slot('title') WORKSHOP @endslot
@endcomponent
@component('components.alert')@endcomponent
<livewire:admin.workshop.table />
<livewire:admin.workshop.create />
@endsection

@section('script')
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/glightbox/glightbox.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/lightbox.init.js') }}"></script>

<script>
    window.addEventListener('createModal', event => {
        $('.tambah-workshop').modal('show');
    })
    window.addEventListener('closeModalTambah', event => {
        $('.tambah-workshop').modal('hide');
    })
</script>
@endsection