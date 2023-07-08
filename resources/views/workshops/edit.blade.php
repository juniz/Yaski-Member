@extends('layouts.master')

@section('title')
@lang('translation.Starter_Page')
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
                <form action="{{ route('workshops.update', $workshop) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul</label>
                        <input type="text" value="{{ $workshop->title }}" class="form-control" id="title" name="title"
                            placeholder="Judul" required>
                        @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="ckeditor-classic" name="description" rows="3">
                            {{ $workshop->description }}
                        </textarea>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="date" class="form-label">Tanggal Mulai</label>
                            <input type="date" value="{{ $workshop->start }}" class="form-control" id="start"
                                name="start" required>
                            @error('start')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="date" class="form-label">Tanggal Selesai</label>
                            <input type="date" value="{{ $workshop->end }}" class="form-control" id="end" name="end"
                                required>
                            @error('end')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Gambar</label>
                        <input type="file" value="{{ old('image') }}" class="form-control" id="image" name="image"
                            placeholder="Gambar">
                        @error('image')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ URL::asset('assets/js/pages/alert.init.js') }}"></script>
<script src="{{ URL::asset('assets/libs/@ckeditor/@ckeditor.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/form-editor.init.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection