@extends('layouts.master')

@section('title')
Validasi Workshop
@endsection
@section('css')
<link href="{{ URL::asset('assets/libs/glightbox/glightbox.min.css') }}" rel="stylesheet">
@endsection

@section('content')
@component('components.alert')@endcomponent
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header @if($sertifikat) bg-success @else bg-danger @endif">
                @if($sertifikat) 
                    <h1 class="card-title text-bold text-center text-light"><i class="bx bx-check-circle"></i> Document Valid</h1>
                @else
                    <h1 class="card-title text-bold text-center text-light"><i class="bx bx-x-circle"></i> Document Tidak Valid</h1>
                @endif
            </div>
            <div class="card-body p-4">
                <div class="flex flex-row justify-content-between">
                    @if($sertifikat)
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">No. Sertifikat</div>
                                {{ $sertifikat->no_sertifikat }}
                            </div>
                            {{-- <span class="badge bg-primary rounded-pill">14</span> --}}
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">Nama</div>
                                {{ $sertifikat->nama }}
                            </div>
                            {{-- <span class="badge bg-primary rounded-pill">14</span> --}}
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">Instansi</div>
                                {{ $sertifikat->instansi }}
                            </div>
                            {{-- <span class="badge bg-primary rounded-pill">14</span> --}}
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                <div class="fw-bold">Acara</div>
                                {{ $sertifikat->workshop->nama }}
                                </div>
                                {{-- <span class="badge bg-primary rounded-pill">14</span> --}}
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                <div class="fw-bold">Tanggal Pelaksanaan</div>
                                {{ $sertifikat->workshop->tgl_mulai }} s/d {{ $sertifikat->workshop->tgl_sampai }}
                                </div>
                                {{-- <span class="badge bg-primary rounded-pill">14</span> --}}
                            </li>
                        </ul>
                        <div class="d-flex flex-row justify-content-center mt-4">
                            <h4>Telah dikeluarkan sertifikat pelatihan dengan identitas di atas</h4>
                        </div>
                    @else
                        <h5 class="text-center">Data Tidak Ditemukan</h5>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
