@extends('layouts.master-layouts')

@section('title')
Materi Workshop
@endsection

@section('css')
<style>
    .material-hero {
        background: #ffffff;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 24px;
    }

    .material-card {
        border: 1px solid #e9ecef;
        border-radius: 8px;
        height: 100%;
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    .material-card:hover {
        border-color: #b9d7ff;
        box-shadow: 0 6px 18px rgba(15, 23, 42, .08);
    }

    .material-icon {
        width: 44px;
        height: 44px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

</style>
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Workshop @endslot
@slot('title') Materi Workshop @endslot
@endcomponent

<div class="material-hero mb-4">
    <div class="d-flex align-items-start gap-3">
        <div class="material-icon bg-soft-primary text-primary">
            <i class="bx bx-book-content"></i>
        </div>
        <div>
            <h4 class="mb-2">{{ $workshop->nama }}</h4>
            <div class="text-muted">
                Materi workshop dapat dibuka dan didownload tanpa login.
            </div>
            <div class="mt-2 small text-muted">
                @if($workshop->tgl_mulai && $workshop->tgl_selesai)
                    <i class="bx bx-calendar me-1"></i>
                    {{ \Carbon\Carbon::parse($workshop->tgl_mulai)->format('d M Y') }}
                    sampai
                    {{ \Carbon\Carbon::parse($workshop->tgl_selesai)->format('d M Y') }}
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    @forelse($workshop->materials as $material)
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card material-card mb-0">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex align-items-start gap-3 mb-3">
                        @if($material->type === 'file')
                            <div class="material-icon bg-soft-info text-info">
                                <i class="bx bx-file"></i>
                            </div>
                        @else
                            <div class="material-icon bg-soft-warning text-warning">
                                <i class="bx bx-link"></i>
                            </div>
                        @endif
                        <div class="flex-grow-1">
                            <span class="badge {{ $material->type === 'file' ? 'bg-soft-info text-info' : 'bg-soft-warning text-warning' }} mb-2">
                                {{ $material->type === 'file' ? 'File' : 'Link' }}
                            </span>
                            <h5 class="font-size-16 mb-1">{{ $material->title }}</h5>
                            @if($material->description)
                                <div class="text-muted small">{{ $material->description }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-auto d-flex gap-2">
                        <a href="{{ route('workshop.material.open', $material->id) }}" target="_blank" class="btn btn-outline-primary flex-fill">
                            <i class="bx bx-show me-1"></i> Buka
                        </a>
                        @if($material->type === 'file')
                            <a href="{{ route('workshop.material.download', $material->id) }}" class="btn btn-primary flex-fill">
                                <i class="bx bx-download me-1"></i> Download
                            </a>
                        @else
                            <a href="{{ route('workshop.material.open', $material->id) }}" target="_blank" class="btn btn-primary flex-fill">
                                <i class="bx bx-link-external me-1"></i> Link
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="bx bx-info-circle display-5 text-muted d-block mb-3"></i>
                    <h5 class="mb-1">Belum ada materi workshop</h5>
                    <div class="text-muted">Materi akan tampil di halaman ini setelah ditambahkan oleh admin.</div>
                </div>
            </div>
        </div>
    @endforelse
</div>
@endsection

@section('script')
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
