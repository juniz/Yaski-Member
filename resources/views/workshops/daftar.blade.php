@extends('layouts.master')

@section('title')
Workshop
@endsection
@section('css')
<link href="{{ URL::asset('assets/libs/glightbox/glightbox.min.css') }}" rel="stylesheet">
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Daftar @endslot
@slot('title') WORKSHOP @endslot
@endcomponent
@component('components.alert')@endcomponent
@php
$workshop = \App\Models\Workshop::latest()->first();
@endphp
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body p-4">
                @if($workshop)
                <div class="row mb-3">
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-lg-3 col-sm-5 col-md-4 mb-sm-7">
                                <img src="{{url('storage/workshop/'.$workshop->gambar)}}" class="img-thumbnail" alt="{{$workshop->nama}}">
                            </div>
                            <div class="col-lg-9 col-sm-7 col-md-8 pt-3 pl-xl-4 pl-lg-5 pl-sm-4">
                                <h2>{{ $workshop->nama }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 text-center pt-5">
                        <span class="text-muted d-block mb-2">Terbuka Hingga:</span>
                        <b>{{ \Carbon\Carbon::parse($workshop->tgl_selesai)->isoFormat('LL') }}</b>
                        <span class="text-muted d-block mt-3 mb-2">Sisa Kuota:</span>
                        <b>{{$workshop->kuota}} peserta</b>
                    </div>
                </div>
                <div class="row border-top pt-3">
                    <div class="col-lg-9 order-lg-1 order-2 col-lg-push-3 pr-lg-5">
                        <h3>Deskripsi</h3>
                        <div class="fr-view mb-5">
                            {!! $workshop->deskripsi !!}
                        </div>
                    </div>
                    <div class="col-lg-3 order-lg-2 order-1 pl-lg-4 mb-5 event-info">

                        <div class="mb-5">
                            <button type="button" class="btn btn-primary">Daftar</button>
                        </div>


                        <div class="mb-5">
                        <div class="text-for-element">Jadwal Pelaksanaan</div>
                        <div class="row">
                            <div class="col-sm-3">Mulai</div>
                            <div class="col-sm-9">: <b>{{ \Carbon\Carbon::parse($workshop->tgl_mulai)->isoFormat('LL') }}</b></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">Selesai</div>
                            <div class="col-sm-9">: <b>{{ \Carbon\Carbon::parse($workshop->tgl_selesai)->isoFormat('LL') }}</b></div>
                        </div>
                        </div>
                        <div class="mb-5">
                        <div class="text-for-element">Lokasi</div>
                        <div class="row">
                            <div class="col-sm-2"><i class="fas fa-map-marker-alt"></i></div>
                            <div class="col-sm-10">
                                <b>{!! $workshop->lokasi !!}</b>
                            </div>
                        </div>
                        </div>

                    </div>
                </div>
                @else
                <h3 class="text-center">Workshop Kosong</h3>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/glightbox/glightbox.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/lightbox.init.js') }}"></script>
@endsection