@extends('layouts.master-layouts')

@section('title')
Workshop
@endsection
@section('css')
<link href="{{ URL::asset('assets/libs/glightbox/glightbox.min.css') }}" rel="stylesheet">
<style>
    .timer{
    display:flex;
    }
    .timer h1 + h1:before{
    content:":"
    }

</style>
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Daftar @endslot
@slot('title') WORKSHOP @endslot
@endcomponent
@component('components.alert')@endcomponent
@php
$workshop = \App\Models\Workshop::where('stts', '1')->get();
// $reservation = \App\Models\Reservation::where('workshop_id', $workshop->id ?? '')->where('user_id', Auth::user()->id)->first();
@endphp
<div class="row">
    @forelse($workshop as $item)
    <div class="col-xl-4 col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="pricing-badge">
                    <span class="badge text-white bg-primary">Baru</span>
                </div>
                <div class="product-img position-relative">
                    <img src="{{ url('storage/workshop/'.$item->gambar) }}" alt="{{ $item->nama }}" class="img-fluid mx-auto d-block">
                </div>
                <div class="d-flex justify-content-between align-items-end mt-4">
                    <div class="overflow-hidden">
                        <h5 class="mb-3 text-truncate"><a href="javascript: void(0);" class="text-dark">{{ $item->nama }}</a></h5>
                        <span class="d-inline-block text-truncate" style="max-width: 350px; max-height: 75px;">
                            {!! $item->deskripsi !!}
                        </span>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-start">
                <div></div>
                <div>
                    <a href="{{  url('/workshop/detail/'.$item->slug) }}" class="link-primary stretched-link">Lihat detail <i class="bx bx-right-arrow-alt"></i></a>
                </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="card">
        <div class="card-body">
            <h3 class="text-center">Workshop Kosong</h3>
        </div>
    </div>
    @endforelse
</div>
{{-- <livewire:component.form-pendaftaran /> --}}
{{-- <livewire:profile.daftar-workshop /> --}}
@endsection

@section('script')
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/glightbox/glightbox.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/lightbox.init.js') }}"></script>
<script>
    window.livewire.on('closeModal', () => {
        $('.orderdetailsModal').modal('hide');
    });

    Livewire.on('open-modal-workshop', () => {
        $('.daftar-workshop-modal').modal('show');
    });

    function timer(expiry) {
    return {
        expiry: expiry,
        remaining:null,
        init() {
        this.setRemaining()
        setInterval(() => {
            this.setRemaining();
        }, 1000);
        },
        setRemaining() {
        const diff = this.expiry - new Date().getTime();
        this.remaining =  parseInt(diff / 1000);
        },
        days() {
        return {
            value:this.remaining / 86400,
            remaining:this.remaining % 86400
        };
        },
        hours() {
        return {
            value:this.days().remaining / 3600,
            remaining:this.days().remaining % 3600
        };
        },
        minutes() {
            return {
            value:this.hours().remaining / 60,
            remaining:this.hours().remaining % 60
        };
        },
        seconds() {
            return {
            value:this.minutes().remaining,
        };
        },
        format(value) {
        return ("0" + parseInt(value)).slice(-2)
        },
        time(){
            return {
            days:this.format(this.days().value),
            hours:this.format(this.hours().value),
            minutes:this.format(this.minutes().value),
            seconds:this.format(this.seconds().value),
        }
        },
    }
}

</script>
@endsection