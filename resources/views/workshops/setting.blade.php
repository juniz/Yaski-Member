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
                <form method="POST" action="{{ route('workshop.setting.simpan', ['id' => $id]) }}">
                    @csrf
                    {{-- <x-ui.input-row id="id" type="hidden" value="{{ $id }}" /> --}}
                    <x-ui.textarea label="Deskripsi" id="deskripsi" />
                    <div class="my-3">
                        <label for="Template" class="form-label">Template</label>
                        <input class="form-control" type="file" id="template" name="template" accept="pplication/pdf">
                        @error('template')
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
