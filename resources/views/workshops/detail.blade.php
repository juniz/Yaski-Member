@extends('layouts.master-layouts')

@section('title')
Workshop
@endsection
@section('css')
<link href="{{ URL::asset('assets/libs/glightbox/glightbox.min.css') }}" rel="stylesheet">
<style>
    .timer{
    display:flex;
    }
    .timer h1 + h1:before{
    content:":"
    }

</style>
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Daftar @endslot
@slot('title') WORKSHOP @endslot
@endcomponent
@component('components.alert')@endcomponent
<livewire:component.form-pendaftaran />
<livewire:profile.daftar-workshop />
@endsection

@section('script')
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/glightbox/glightbox.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/lightbox.init.js') }}"></script>
<script>
    window.livewire.on('closeModal', () => {
        $('.orderdetailsModal').modal('hide');
    });

    Livewire.on('open-modal-workshop', () => {
        $('.daftar-workshop-modal').modal('show');
    });

</script>
@endsection