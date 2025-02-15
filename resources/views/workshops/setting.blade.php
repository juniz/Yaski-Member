@extends('layouts.master')

@section('title')
Setting Workshop
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
                <form method="POST"  action="{{ route('workshop.setting.simpan', ['id' => $id]) }}" enctype="multipart/form-data">
                    @csrf
                    {{-- <x-ui.input-row id="id" type="hidden" value="{{ $id }}" /> --}}
                    <x-ui.textarea label="Deskripsi" id="deskripsi" />
                    <div class="my-3">
                        <label for="file_template" class="form-label">file_template</label>
                        <input class="form-control" type="file" id="file_template" name="file_template" accept="image/*">
                        @error('file_template')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
