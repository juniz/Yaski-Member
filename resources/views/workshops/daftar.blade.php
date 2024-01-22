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
$workshop = \App\Models\Workshop::latest()->first();
// $reservation = \App\Models\Reservation::where('workshop_id', $workshop->id ?? '')->where('user_id', Auth::user()->id)->first();
@endphp
@if($workshop)
<livewire:component.form-pendaftaran />
@else
<h3 class="text-center">Workshop Kosong</h3>
@endif
@endsection

@section('script')
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/glightbox/glightbox.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/lightbox.init.js') }}"></script>
<script>
    window.livewire.on('closeModal', () => {
        $('.orderdetailsModal').modal('hide');
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