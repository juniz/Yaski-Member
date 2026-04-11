@extends('layouts.master')

@section('title')
Validasi Sertifikat
@endsection
@section('css')
<link href="{{ URL::asset('assets/libs/glightbox/glightbox.min.css') }}" rel="stylesheet">
<style>
    .validasi-card {
        max-width: 700px;
        margin: 0 auto;
    }
    .valid-header {
        background: linear-gradient(135deg, #28a745, #20c997);
        padding: 30px;
        text-align: center;
    }
    .invalid-header {
        background: linear-gradient(135deg, #dc3545, #e74c3c);
        padding: 30px;
        text-align: center;
    }
    .valid-header h1, .invalid-header h1 {
        color: white;
        font-size: 24px;
        margin: 0;
    }
    .valid-header i, .invalid-header i {
        font-size: 48px;
        color: white;
        display: block;
        margin-bottom: 10px;
    }
    .detail-item {
        padding: 12px 16px;
        border-bottom: 1px solid #eee;
    }
    .detail-item:last-child {
        border-bottom: none;
    }
    .detail-label {
        font-weight: 600;
        color: #495057;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 2px;
    }
    .detail-value {
        font-size: 16px;
        color: #212529;
    }
    .sertifikat-preview {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
</style>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="card validasi-card shadow-sm">
            @if($sertifikat)
                <div class="valid-header">
                    <i class="bx bx-check-circle"></i>
                    <h1>Sertifikat Valid</h1>
                </div>
                <div class="card-body p-0">
                    {{-- Preview sertifikat images --}}
                    @if($sertifikat->file_sertifikat)
                        <div class="p-3">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <p class="small text-muted mb-1"><i class="bx bx-image"></i> Halaman Depan:</p>
                                    <div class="sertifikat-preview">
                                        <img src="{{ url('sertifikat/' . $sertifikat->id . '/preview') }}"
                                             alt="Sertifikat Depan" class="img-fluid w-100">
                                    </div>
                                </div>
                                @if($sertifikat->file_sertifikat_belakang)
                                    <div class="col-12 mb-2">
                                        <p class="small text-muted mb-1"><i class="bx bx-image"></i> Halaman Belakang:</p>
                                        <div class="sertifikat-preview">
                                            <img src="{{ url('sertifikat/' . $sertifikat->id . '/preview-back') }}"
                                                 alt="Sertifikat Belakang" class="img-fluid w-100">
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <div class="detail-item">
                        <div class="detail-label">No. Sertifikat</div>
                        <div class="detail-value">{{ $sertifikat->no_sertifikat }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Nama</div>
                        <div class="detail-value">{{ $sertifikat->nama ?? $sertifikat->peserta->nama ?? '-' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Instansi</div>
                        <div class="detail-value">{{ $sertifikat->instansi ?? $sertifikat->peserta->transaction->nama_rs ?? '-' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Acara</div>
                        <div class="detail-value">{{ $sertifikat->workshop->nama ?? '-' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Tanggal Pelaksanaan</div>
                        <div class="detail-value">{{ $sertifikat->workshop->tgl_mulai ?? '-' }} s/d {{ $sertifikat->workshop->tgl_sampai ?? $sertifikat->workshop->tgl_selesai ?? '-' }}</div>
                    </div>

                    <div class="p-3 bg-light text-center">
                        <p class="text-muted mb-3">
                            <i class="bx bx-check-shield"></i>
                            Telah dikeluarkan sertifikat pelatihan dengan identitas di atas
                        </p>

                        @if($sertifikat->file_sertifikat)
                            <a href="{{ url('sertifikat/' . $sertifikat->id . '/download') }}" class="btn btn-success btn-lg">
                                <i class="bx bx-download"></i> Download Sertifikat
                            </a>
                        @endif
                    </div>
                </div>
            @else
                <div class="invalid-header">
                    <i class="bx bx-x-circle"></i>
                    <h1>Sertifikat Tidak Valid</h1>
                </div>
                <div class="card-body text-center p-4">
                    <p class="text-muted mb-0">
                        Data sertifikat tidak ditemukan. Pastikan QR Code yang di-scan benar.
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
