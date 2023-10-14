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
                <div class="row mb-3">
                    <div class="col-lg-10">
                        <div class="row">
                            <div class="col-lg-3 col-sm-5 col-md-4 mb-sm-7">
                                <img src="{{url('storage/workshop/'.$workshop->gambar)}}" class="img-thumbnail" alt="{{$workshop->nama}}">
                            </div>
                            <div class="col-lg-9 col-sm-7 col-md-8 pt-3 pl-xl-4 pl-lg-5 pl-sm-4">
                                <h2>{{ $workshop->nama }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 text-center pt-5">
                        <span class="text-muted d-block mb-2">Terbuka Hingga:</span>
                        <b>Oct 14, 2023</b>
                        <span class="text-muted d-block mt-3 mb-2">Sisa Kuota:</span>
                        <b>129 peserta</b>
                    </div>
                </div>
                <div class="row border-top pt-3">
                    <div class="col-lg-9 order-lg-1 order-2 col-lg-push-3 pr-lg-5">
                        <h3>Deskripsi</h3>
                        <div class="fr-view mb-5">
                            <p>Hello, Google Enthusiasts!????</p><p>Are you interested in learning more about GDSC? GDSC is Google Developer Student Club, a community of students who share interest and passion in technology. We are holding an info &amp; sharing session that will discuss the vision, mission, activities, and benefits of joining GDSC. This event is free and open to all students. Register now and don't miss the opportunity to get to know GDSC better!</p><p>Register here :<br><br></p><p>Note the date!</p><p>???? : Saturday, October 14, 2023</p><p>⏰ : 09.00 - 12.00 WITA</p><p>???? : Google Meet</p><p>We grow as one! ????</p><p><br></p><p>#GoogleDevelopers #DeveloperStudentClubs #GDSCIndonesia #GDSCULM #GDSC2023</p>
                        </div>
                        <div class="fb-like fb_iframe_widget" data-share="true" data-href="https://www.dicoding.com/events/4875" data-layout="button_count" fb-xfbml-state="rendered" fb-iframe-plugin-query="app_id=775841782490020&amp;container_width=657&amp;href=https%3A%2F%2Fwww.dicoding.com%2Fevents%2F4875&amp;layout=button_count&amp;locale=en_US&amp;sdk=joey&amp;share=true"><span style="vertical-align: bottom; width: 150px; height: 28px;"><iframe name="f1f1a966a03a8be" width="1000px" height="1000px" data-testid="fb:like Facebook Social Plugin" title="fb:like Facebook Social Plugin" frameborder="0" allowtransparency="true" allowfullscreen="true" scrolling="no" allow="encrypted-media" style="border: medium; visibility: visible; width: 150px; height: 28px;" src="https://www.facebook.com/v2.12/plugins/like.php?app_id=775841782490020&amp;channel=https%3A%2F%2Fstaticxx.facebook.com%2Fx%2Fconnect%2Fxd_arbiter%2F%3Fversion%3D46%23cb%3Df3630405d25238e%26domain%3Dwww.dicoding.com%26is_canvas%3Dfalse%26origin%3Dhttps%253A%252F%252Fwww.dicoding.com%252Ff3afc3fd4e3f768%26relation%3Dparent.parent&amp;container_width=657&amp;href=https%3A%2F%2Fwww.dicoding.com%2Fevents%2F4875&amp;layout=button_count&amp;locale=en_US&amp;sdk=joey&amp;share=true" class=""></iframe></span></div>
                                                                                                                    
                        
                        
                    </div>
                    <div class="col-lg-3 order-lg-2 order-1 pl-lg-4 mb-5 event-info">

                        <div class="d-registration mb-5">
                        <div class="text-for-element">Keikutsertaan</div>
                            <p>Silakan masuk dahulu ke Dicoding untuk dapat mendaftar ke event ini secara gratis.</p>
                        <a href="#login-modal" data-toggle="modal" class="btn btn-primary shadow btn--full-width d-unauthenticated-registration-link">Masuk</a>
                            
                        </div>


                        <div class="mb-5">
                        <div class="text-for-element">Jadwal Pelaksanaan</div>
                        <div class="row">
                            <div class="col-sm-3">Mulai</div>
                            <div class="col-sm-9">: <b>14 Oct 2023</b> 09:00</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">Selesai</div>
                            <div class="col-sm-9">: <b>24 Oct 2023</b> 12:00</div>
                        </div>
                        </div>
                        <div class="mb-5">
                        <div class="text-for-element">Lokasi</div>
                        <div class="row">
                            <div class="col-sm-2"><i class="fas fa-map-marker-alt"></i></div>
                            <div class="col-sm-10">
                                <p>http://tiny.cc/InfoSessionGDSC</p>
                                <b>Kota Banjarmasin</b>
                            </div>
                        </div>
                        </div>

                    </div>
                </div>
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