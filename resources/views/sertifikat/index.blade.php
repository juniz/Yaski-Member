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
                <h5 class="text-center mb-4">Data Sertifikat Sudah Diinput</h5>

                {{-- Show preview if file exists --}}
                @if($sertifikat->file_sertifikat)
                    <div class="text-center mb-4">
                        <img src="{{ url('sertifikat/' . $id . '/preview') }}"
                             alt="Sertifikat" class="img-fluid rounded shadow" style="max-height: 500px;">
                        <div class="mt-3">
                            <a href="{{ url('sertifikat/' . $id . '/download') }}" class="btn btn-success">
                                <i class="bx bx-download"></i> Download Sertifikat
                            </a>
                        </div>
                    </div>
                @else
                    <div class="alert alert-info text-center">
                        <i class="bx bx-info-circle"></i> Sertifikat sedang diproses. Silakan cek kembali nanti.
                    </div>
                @endif

                <div class="card bg-light">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Nama:</strong> {{ $sertifikat->nama }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Instansi:</strong> {{ $sertifikat->instansi }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>No. Sertifikat:</strong> {{ $sertifikat->no_sertifikat }}</p>
                            </div>
                        </div>
                    </div>
                </div>
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