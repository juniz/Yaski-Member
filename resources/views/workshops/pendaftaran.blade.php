@extends('layouts.master-layouts')

@section('title')
@lang('Pendaftran Workshop')
@endsection
@section('css')
<link href="{{ URL::asset('assets/libs/choices.js/choices.js.min.css') }}" rel="stylesheet">
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
                <form id="payment-formm" method="POST" action="{{ route('pendaftaran.transaksi') }}">
                    {{-- <div x-data="{ jml:1 }">
                        <template x-for="i in jml">
                            <x-ui.input-row label="Nama" id="nama" />
                        </template>
                        <button type="button" class="btn btn-primary" x-on:click="jml++">+</button>
                    </div> --}}
                    <x-ui.input-row label="Nama" class="uppercase" id="nama" />
                    <x-ui.select-row label="Jenis Kelamin" id="jenis_kelamin" placeholder="Pilih jenis kelamin">
                        <option value="">Pilih jenis kelamin</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </x-ui.select>
                    <div class="row">
                        <div class="col-sm-3">

                        </div>
                        <div class="col-sm-9 mb-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="pribadi">
                                <label class="form-check-label" for="pribadi">Pribadi</label>
                            </div>
                        </div>
                    </div>
                    <x-ui.input-row label="Nama RS" id="nama_rs" />
                    <x-ui.input-row label="Kode RS" id="kode_rs" />
                    <x-ui.select-row label="Kepemilikan RS" id="kepemilikan_rs" placeholde="Pilih kepemilikan RS">
                        <option value="">Pilih kepemilikan RS</option>
                        <option value="swasta">Swasta</option>
                        <option value="pemerintah">Pemerintah</option>
                    </x-ui.select>
                    <div class="row">
                        <label for="provinsi" class="col-sm-3 col-form-label font-size-13 required">Provinsi</label>
                        <div class="col-sm-9">
                            <select class="form-select" data-trigger name="provinsi" id="provinsi"
                            placeholder="Cari Provinsi">
                            <option value="">Pilih provinsi</option>
                            @foreach ($provinces as $province)
                            <option value="{{ $province->id }}">{{ $province->name }}</option>
                            @endforeach
                        </select>
                        <div class="text-danger" id="provinsiError" data-ajax-feedback="provinsi"></div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="kabupaten" class="col-sm-3 col-form-label font-size-13 required">Kabupaten / Kota</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="kabupaten" id="kabupaten" placeholder="Cari Kabupaten">
                            </select>
                            <div class="text-danger" id="kabupatenError" data-ajax-feedback="kabupaten"></div>
                        </div>
                    </div>
                    <x-ui.input-row label="Nomor HP" id="telp" />
                    <x-ui.input-row label="Email" type="email" class="lowercase" id="email" />
                    <x-ui.select-row label="Ukuran Baju" id="baju" placeholder="Pilih ukuran baju">
                        <option value="">Pilih ukuran baju</option>
                        <option value="S">S</option>
                        <option value="M">M</option>
                        <option value="L">L</option>
                        <option value="XL">XL</option>
                        <option value="XXL">XXL</option>
                    </x-ui.select>
                    <x-ui.select-row label="Paket Harga" id="harga" placeholder="Pilih paket harga">
                        <option value="">Pilih paket harga</option>
                        @foreach($workshop->paket as $paket)
                        <option value="{{$paket->id}}">{{$paket->nama}} - Rp {{$paket->harga}}</option>
                        @endforeach
                    </x-ui.select>
                    <div class="d-flex flex-row justify-content-between">
                        <a type="reset" href="{{ route('workshop.list') }}" class="btn btn-danger">Kembali</a>
                        <button type="submit" class="btn btn-primary">Daftar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ URL::asset('assets/libs/choices.js/choices.js.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script>
    const query_task = new Choices('#kabupaten', {
            removeItemButton: true,
            searchPlaceholderValue: 'Pilih Kabupaten / Kota', 
            placeholder: true,
    });
    query_task.passedElement.element.addEventListener('addItem', () => reset(), false);
    query_task.passedElement.element.addEventListener('removeItem', () => reset(), false);

    function reset(id) {
        query_task.clearChoices();
        query_task.setChoices(function() { 
            return fetch( 
                "{{ url('get-kabupaten') }}" + "/" + id
            ) 
            .then(function(response) { 
                return response.json(); 
            }) 
            .then(function(data) { 
                return data.map(function(response) { 
                    return { label: response.name, value: response.id }; 
                }); 
            }); 
        });
    }

    $("#provinsi").on('change', function() {
        let id = $(this).val();
        query_task.removeActiveItems();
        reset(id);
    });

    $("#pribadi").on('change', function() {
        if ($(this).is(':checked')) {
            $("#nama_rs").val("");
            $("#kode_rs").val("");
            $("#kepemilikan_rs").val("");
            $("#nama_rs").attr('disabled', true);
            $("#kode_rs").attr('disabled', true);
            $("#kepemilikan_rs").attr('disabled', true);
        } else {
            $("#nama_rs").attr('disabled', false);
            $("#kode_rs").attr('disabled', false);
            $("#kepemilikan_rs").attr('disabled', false);
        }
    });

    $("#payment-form").on('submit', function(e) {
        e.preventDefault();
        let data = {
            _token: "{{ csrf_token() }}",
            workshop_id: "{{ $workshop->id }}",
            nama: $("#nama").val().toUpperCase(),
            jenis_kelamin: $("#jenis_kelamin").val(),
            pribadi:$("#pribadi").is(':checked') ? 1 : 0,
            nama_rs: $("#nama_rs").val(),
            kode_rs: $("#kode_rs").val(),
            kepemilikan_rs: $("#kepemilikan_rs").val(),
            provinsi: $("#provinsi").val(),
            kabupaten: $("#kabupaten").val(),
            telp: $("#telp").val(),
            email: $("#email").val().toLowerCase(),
            baju: $("#baju").val(),
            harga: $("#harga").val(),
        };
        $.ajax({
            url: "{{ route('pendaftaran.transaksi') }}",
            type: "POST",
            data: data,
            success: function(data) {
                console.log(data);
                // window.location = data.snap_token;
                if (data.status == "success") {
                    snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            // console.log(result);
                            window.location.href = "{{ route('workshop.list') }}";
                            // $.ajax({
                            //     url: "{{ route('pendaftaran.store') }}",
                            //     type: "POST",
                            //     data: data,
                            //     success: function(data) {
                            //         console.log(data);
                            //         if (data.status == "success") {
                            //             window.location.href = "{{ route('workshop.list') }}";
                            //         }
                            //     },
                            //     error: function(xhr, status, error) {
                            //         let err = JSON.parse(xhr.responseText);
                            //         alert(err.message);
                            //     }
                            // });
                        },
                        onPending: function(result) {
                            console.log(result);
                        },
                        onError: function(result) {
                            console.log(result);
                        }
                    });
                }else{
                    alert(data.message);
                }
            },
            error: function(xhr, status, error) {
                // console.log(xhr);
                let err = JSON.parse(xhr.responseText);
                if (err.errors) {
                    $.each(err.errors, function(key, value) {
                        $("#" + key + "Error").html(value);
                    });
                }
            }
        });
    });
</script>
@endsection