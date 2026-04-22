@extends('layouts.master')

@section('title')
Kwitansi Workshop
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Workshop @endslot
@slot('title') KWITANSI @endslot
@endcomponent
@component('components.alert')@endcomponent

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="bx bx-receipt"></i> Kwitansi Workshop
                </h5>
                <div class="btn-group">
                    <a href="{{ route('workshop.kwitansi.download-pdf', $id) }}" class="btn btn-success btn-sm">
                        <i class="bx bx-download"></i> Download Semua PDF
                    </a>
                    <a href="{{ route('workshop.peserta', $id) }}" class="btn btn-secondary btn-sm">
                        <i class="bx bx-arrow-back"></i> Peserta
                    </a>
                </div>
            </div>
            <div class="card-body p-4">
                <livewire:kwitansi-table :id-workshop="$id" />
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
