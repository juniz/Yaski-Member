@extends('layouts.master-layouts')

@section('title')
Transaksi Berhasil
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Pages @endslot
@slot('title') WORKSHOP @endslot
@endcomponent
@component('components.alert')@endcomponent
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body p-4">
                <div class="d-flex flex-column">
                    <div class="d-flex flex-row justify-content-center">
                        <div class="text-center">
                            <img src="{{ URL::asset('images/success.png') }}" alt="success" height="80">
                        </div>
                    </div>
                    <div class="d-flex flex-row justify-content-center mt-4">
                        <div class="text-center">
                            <h3>Terima kasih atas transaksi Anda.</h3>
                        </div>
                    </div>
                    <div class="d-flex flex-row justify-content-center mt-4">
                        <div class="text-center">
                            <p>Transaksi Anda telah berhasil dilakukan.</p>
                        </div>
                    </div>
                    <div class="d-flex flex-row justify-content-center mt-4">
                        <div class="text-center">
                            <a href="{{ route('workshops.index') }}" class="btn btn-primary">Kembali ke Workshop</a>
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
@endsection