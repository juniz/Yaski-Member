@extends('layouts.master')

@section('title')
Sertifikat Peserta Workshop
@endsection
@section('css')
<link href="{{ URL::asset('assets/libs/glightbox/glightbox.min.css') }}" rel="stylesheet">
@endsection

@section('content')
@component('components.alert')@endcomponent
<div class="card">
    <div class="card-body">
        @if($sertifikat)
            @if(isset($sertifikat->nama))
                <h5 class="text-center">Data Sertifikat Sudah Diinput</h5>
            @else
                <form method="POST" action="{{ route('sertifikat.simpan', ['id' => $id]) }}">
                    @csrf
                    <x-ui.input-row label="Nama" id="nama" placeholder='Isikan nama lengkap beserta gelar' />
                    <x-ui.input-row label="Instansi" id="instansi" />
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            @endif
        @else
        <h5 class="text-center">Data Tidak Ditemukan</h5>
        @endif
    </div>
</div>
@endsection

@section('script')
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection