@extends('layouts.master')

@section('title')
Peserta Workshop
@endsection
@section('css')
<link href="{{ URL::asset('assets/libs/glightbox/glightbox.min.css') }}" rel="stylesheet">
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
                {{-- <div class="d-flex flex-row mb-4">
                    <div class="mx-auto">
                        <div style="width: 500" id="reader"></div>
                    </div>
                </div> --}}
                <livewire:peserta-table :id-workshop="$id" />
                {{-- <livewire:transaction-table :id-workshop="$id" /> --}}
                {{-- <livewire:component.scan-qr /> --}}
            </div>
        </div>
    </div>
</div>
<livewire:component.modal-ubah-pembayaran />
@endsection

@section('script')
<script src="{{ URL::asset('assets/libs/datatables.net/datatables.net.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/datatables.net-bs4/datatables.net-bs4.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/datatables.net-buttons/datatables.net-buttons.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/datatables.net-buttons-bs4/datatables.net-buttons-bs4.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/jszip/jszip.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/datatables.net-responsive/datatables.net-responsive.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/datatables.net-responsive-bs4/datatables.net-responsive-bs4.min.js') }}">
</script>
<script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/glightbox/glightbox.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/lightbox.init.js') }}"></script>
<script src="{{ asset('assets/js/html5-qrcode.min.js') }}"></script>
<script>
    Livewire.on('scanQr', () => {
        $('#qrcode-modal').modal('show');
    });

    $("#qrcode-button").click(function () {
        let transaction = $(this).data('id');
        Livewire.emit('transaction-set', transaction);
        $('#qrcode-modal').modal('show');
    });

    function onScanSuccess(decodedText, decodedResult) {
        // Handle on success condition with the decoded text or result.
        // console.log(`Scan result: ${decodedText}`, decodedResult);
        Livewire.emit('get-transaction', decodedText);
    }

    Livewire.on('ubahPeserta', () => {
        $('#changePaymentModal').modal('show');
    });

    Livewire.on('pembayaranTersimpan', () => {
        $('#changePaymentModal').modal('hide');
    });

    var html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", { fps: 10, qrbox: 250 });
    html5QrcodeScanner.render(onScanSuccess);
</script>

@endsection