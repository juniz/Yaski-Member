@extends('layouts.master')

@section('title')
Sertifikat Workshop
@endsection
@section('css')
<link href="{{ URL::asset('assets/libs/glightbox/glightbox.min.css') }}" rel="stylesheet">
@endsection

@section('content')
@component('components.alert')@endcomponent
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="bx bx-certification"></i> Sertifikat Workshop
                </h5>
                <div class="btn-group">
                    <form method="POST" action="{{ route('workshop.generate.sertifikat', $id) }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm me-1" onclick="return confirm('Generate sertifikat untuk semua peserta yang belum memiliki sertifikat?')">
                            <i class="bx bx-play-circle"></i> Generate Semua
                        </button>
                    </form>
                    <form method="POST" action="{{ route('workshop.regenerate.sertifikat', $id) }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-warning btn-sm me-1" onclick="return confirm('Regenerate SEMUA sertifikat? Ini akan menimpa file yang sudah ada.')">
                            <i class="bx bx-refresh"></i> Regenerate Semua
                        </button>
                    </form>
                    <a href="{{ route('workshop.download-bulk-pdf', $id) }}" class="btn btn-success btn-sm me-1">
                        <i class="bx bx-download"></i> Download PDF Gabungan
                    </a>
                    <a href="{{ route('workshop.setting', $id) }}" class="btn btn-secondary btn-sm">
                        <i class="bx bx-cog"></i> Setting Template
                    </a>
                </div>
            </div>
            <div class="card-body p-4">
                <livewire:sertifikat-table :id-workshop="$id" />
            </div>
        </div>
    </div>
</div>
@endsection
