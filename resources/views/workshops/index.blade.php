@extends('layouts.master')

@section('title')
@lang('translation.Starter_Page')
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
                <div class="d-flex flex-row justify-content-end mb-2">
                    <div class="text-sm-end">
                        <a type="button" href="{{ route('workshops.create') }}"
                            class="btn btn-success btn-rounded waves-effect waves-light me-2"><i
                                class="mdi mdi-plus me-1"></i> Tambah </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
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

<script>
    $(document).ready(function () {
        $("#datatables").DataTable({
            language: {
                paginate: {
                    previous: "<i class='mdi mdi-chevron-left'>",
                    next: "<i class='mdi mdi-chevron-right'>",
                },
                info: "Menampilkan halaman _PAGE_ dari _PAGES_",
                lengthMenu: "Tampilkan _MENU_ data",
                zeroRecords: "Tidak ada data yang sesuai dengan pencarian anda",
                infoEmpty: "Data tidak tersedia",
                infoFiltered: "(terfilter dari _MAX_ total data)",
                search: "Cari",
                processing: '<div class="spinner-border text-primary" role="status"></div>',
            },
            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass(
                    "pagination-rounded"
                );
            },
            "order": [[ 0, "desc" ]]
        });

        function deleteData(id) {
            swal({
                title: "Apakah anda yakin?",
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                window.location = "workshops/" + id + "/destroy";
                }
            });
        }
    });
</script>
@endsection