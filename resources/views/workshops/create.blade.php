@extends('layouts.master')
@section('title') Workshop @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Workshop @endslot
@slot('title') Tambah @endslot
@endcomponent
@component('components.alert')@endcomponent
{{-- <livewire:component.tambah-paket /> --}}
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Basic Information</h4>
                <p class="card-title-desc">Fill all information below</p>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('workshop.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="nama">Nama</label>
                                <input id="nama" value="{{ old('nama') }}" name="nama" type="text" class="form-control">
                                @error('nama')<div><span class="text-danger">{{ $message }}</span></div>@enderror
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" id="ckeditor-classic" rows="4">
                                    {{ old('deskripsi') }}
                                </textarea>
                                @error('deskripsi')<div><span class="text-danger">{{ $message }}</span></div>@enderror
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="kuota">Kuota</label>
                                <input id="kuota" value="{{ old('kuota') }}" name="kuota" type="number" class="form-control">
                                @error('kuota')<div><span class="text-danger">{{ $message }}</span></div>@enderror
                            </div>
                            {{-- <div class="mb-3">
                                <label class="control-label">Paket Harga</label>
                                <div class="d-grid col-12">
                                    <livewire:component.tambah-paket />
                                    <button type="button" class="btn btn-secondary">Tambah</button> 
                                </div>
                                <div class="d-flex flex-row">
                                    <div class="d-grid w-100">
                                    </div>
                                    <select class="select2 form-control select2-multiple" multiple="multiple">
                                        <option>Select</option>
                                        <option value="FA">Fashion</option>
                                        <option value="EL">Electronic</option>
                                    </select>
                                    <button class="btn btn-sm btn-secondary" type="button" data-bs-toggle="modal" data-bs-target="#tambah-paket-modal">Tambah</button>
                                </div>
                            </div> --}}
                            <div class="mb-3">
                                <label for="lokasi">Lokasi</label>
                                <textarea class="form-control" id="lokasi" name="lokasi" rows="4">
                                    {{ old('lokasi') }}
                                </textarea>
                                @error('lokasi')<div><span class="text-danger">{{ $message }}</span></div>@enderror
                            </div>
                            <div class="d-flex flex-row gap-3">
                                <div class="mb-3 w-50">
                                    <label for="start_date">Tanggal Mulai</label>
                                    <input id="start_date" value="{{ old('tgl_mulai') }}" name="tgl_mulai" type="date" class="form-control">
                                    @error('tgl_mulai')<div><span class="text-danger">{{ $message }}</span></div>@enderror
                                </div>
                                <div class="mb-3 w-50">
                                    <label for="end_date">Tanggal Selesai</label>
                                    <input id="end_date" name="tgl_selesai" value="{{ old('tgl_selesai') }}" type="date" class="form-control">
                                    @error('tgl_selesai')<div><span class="text-danger">{{ $message }}</span></div>@enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="gambar">Gambar</label>
                                <input id="gambar" name="gambar" type="file" accept="image/*" class="form-control">
                                @error('gambar')<div><span class="text-danger">{{ $message }}</span></div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                        <button type="reset" class="btn btn-secondary waves-effect waves-light">Cancel</button>
                    </div>
                </form>

            </div>
        </div>

        {{-- <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Product Images</h4>
            </div>
            <div class="card-body">
                <form action="/" method="post" class="dropzone">
                    <div class="fallback">
                        <input name="file" type="file" multiple />
                    </div>

                    <div class="dz-message needsclick">
                        <div class="mb-3">
                            <i class="display-4 text-muted bx bxs-cloud-upload"></i>
                        </div>

                        <h4>Drop files here or click to upload.</h4>
                    </div>
                </form>
            </div>

        </div> <!-- end card-->

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Meta Data</h4>
                <p class="card-title-desc">Fill all information below</p>
            </div>
            <div class="card-body">

                <form>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="metatitle">Nama</label>
                                <input id="metatitle" name="productname" type="text" class="form-control" placeholder="Metatitle">
                            </div>
                            <div class="mb-3">
                                <label for="metakeywords">Meta Keywords</label>
                                <input id="metakeywords" name="manufacturername" type="text" class="form-control" placeholder="Meta Keywords">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="metadescription">Meta Description</label>
                                <textarea class="form-control" id="metadescription" rows="5" placeholder="Meta Description"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save Changes</button>
                        <button type="submit" class="btn btn-secondary waves-effect waves-light">Cancel</button>
                    </div>
                </form>

            </div>
        </div> --}}
    </div>
</div>

<!-- end row -->
@endsection
@section('script')
<script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/dropzone/dropzone.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/@ckeditor/@ckeditor.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/ecommerce-select2.init.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/form-editor.init.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>

<script>
    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone(".dropzone", {
        autoProcessQueue: false,
        maxFiles: 10,
        maxFilesize: 2,
        acceptedFiles: ".jpeg,.jpg,.png,.gif",
    });

    myDropzone.on("complete", function (file) {
        myDropzone.removeFile(file);
    });

    window.addEventListener('closePaketModal', event => {
        $('#tambah-paket-modal').modal('hide');
    })
</script>
@endsection
