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
            <div class="card-body p-4">
                {{-- <div class="d-flex flex-row mb-4">
                    <div class="mx-auto">
                        <div style="width: 500" id="reader"></div>
                    </div>
                </div> --}}
                <livewire:sertifikat-table :id-workshop="$id" />
                {{-- <livewire:transaction-table :id-workshop="$id" /> --}}
                {{-- <livewire:component.scan-qr /> --}}
            </div>
        </div>
    </div>
</div>
@endsection
