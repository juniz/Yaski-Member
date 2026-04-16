@extends('layouts.master')
@section('title') Inhouse Training @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Permintaan @endslot
@slot('title') Inhouse Training @endslot
@endcomponent

@if(($mode ?? 'request') == 'admin')
@can('view member')
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <h4 class="card-title text-uppercase mb-0">Daftar Permintaan Pendampingan</h4>
        </div>
    </div>
</div>
<livewire:inhouse-training.table />
<livewire:inhouse-training.persetujuan />
@endcan
@else
<div class="row">
    <div class="col-xl-8 col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-uppercase mb-0">Permintaan Pendampingan Inhouse Training</h4>
            </div>
            <div class="card-body">
                <div wire:ignore.self class="accordion" id="accordionInhouseTraining">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingUploadInhouseTraining">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUploadInhouseTraining" aria-expanded="true" aria-controls="collapseUploadInhouseTraining">
                                1. Upload Surat Permintaan
                            </button>
                        </h2>
                        <div id="collapseUploadInhouseTraining" class="accordion-collapse collapse show" aria-labelledby="headingUploadInhouseTraining" data-bs-parent="#accordionInhouseTraining">
                            <div class="accordion-body">
                                <livewire:component.upload-inhouse-training />
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingStatusInhouseTraining">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseStatusInhouseTraining" aria-expanded="false" aria-controls="collapseStatusInhouseTraining">
                                2. Status Permintaan
                            </button>
                        </h2>
                        <div id="collapseStatusInhouseTraining" class="accordion-collapse collapse" aria-labelledby="headingStatusInhouseTraining" data-bs-parent="#accordionInhouseTraining">
                            <div class="accordion-body">
                                <livewire:component.inhouse-training-status />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
@section('script')
<script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/sweetalert.init.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script>
    window.addEventListener('modalInhouseTraining', event => {
        $('#inhouse-training-modal').modal('show');
    })
    window.addEventListener('docInhouseTraining', event => {
        $('#doc-inhouse-training-modal').modal('show');
    })
    window.addEventListener('editSuratInhouseTraining', event => {
        $('#setuju-inhouse-training-modal').modal('show');
    })
    window.addEventListener('simpanPersetujuanInhouseTraining', event => {
        $('#inhouse-training-modal').modal('hide');
        $('#setuju-inhouse-training-modal').modal('hide');
        $('#tolak-inhouse-training-modal').modal('hide');
    })
    window.addEventListener('openWa', event => {
        window.open(event.detail.url, '_blank');
    })
</script>
@endsection
