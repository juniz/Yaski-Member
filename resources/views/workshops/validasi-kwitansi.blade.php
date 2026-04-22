@extends('layouts.master')

@section('title')
Validasi Kwitansi
@endsection

@section('css')
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
    .valid-header h1,
    .invalid-header h1 {
        color: white;
        font-size: 24px;
        margin: 0;
    }
    .valid-header i,
    .invalid-header i {
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
</style>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="card validasi-card shadow-sm">
            @if($peserta && $data)
                <div class="valid-header">
                    <i class="bx bx-check-circle"></i>
                    <h1>Kwitansi Valid</h1>
                </div>
                <div class="card-body p-0">
                    <div class="detail-item">
                        <div class="detail-label">No. Kwitansi</div>
                        <div class="detail-value">{{ $data['no_kwitansi'] }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">No. Order</div>
                        <div class="detail-value">{{ $data['order_id'] }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Nama Peserta</div>
                        <div class="detail-value">{{ $data['nama'] }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Instansi</div>
                        <div class="detail-value">{{ $data['penerima'] }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Workshop</div>
                        <div class="detail-value">{{ $data['workshop'] }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Paket</div>
                        <div class="detail-value">{{ $data['paket'] ?? '-' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Nominal</div>
                        <div class="detail-value">Rp {{ number_format($data['harga'], 0, ',', '.') }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Tanggal Pelaksanaan</div>
                        <div class="detail-value">{{ $data['tgl_mulai'] }} s/d {{ $data['tgl_selesai'] }}</div>
                    </div>
                    <div class="p-3 bg-light text-center">
                        <p class="text-muted mb-3">
                            <i class="bx bx-check-shield"></i>
                            Kwitansi ini tercatat pada sistem Yaski Member.
                        </p>
                        <a href="{{ route('kwitansi.cetak', $peserta->id) }}" target="_blank" class="btn btn-success btn-lg">
                            <i class="bx bx-printer"></i> Cetak Kwitansi
                        </a>
                    </div>
                </div>
            @else
                <div class="invalid-header">
                    <i class="bx bx-x-circle"></i>
                    <h1>Kwitansi Tidak Valid</h1>
                </div>
                <div class="card-body text-center p-4">
                    <p class="text-muted mb-0">
                        Data kwitansi tidak ditemukan. Pastikan QR Code yang di-scan benar.
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
