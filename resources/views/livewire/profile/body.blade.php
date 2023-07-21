<div>
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-row justify-content-between">
                <h4 class="card-title text-uppercase mb-0">{{ $fasyankes->nama ?? 'Data Fasyankes Kosong' }}
                </h4>
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                    data-bs-target=".update-fasyankes"><i class="bx bx-plus me-1"></i>@if(empty($fasyankes))
                    Tambah Fasyankes @else Ubah
                    Fasyankes @endif</button>
            </div>
        </div>

        <div class="card-body">
            @if(!empty($fasyankes))
            <div>
                <div class="pb-3">
                    <h5 class="font-size-15">Kode :</h5>
                    <div class="text-muted">
                        <p class="mb-2">{{ $fasyankes->kode }}</p>
                    </div>
                </div>

                <div class="pt-3">
                    <h5 class="font-size-15">Jenis Fasyankes :</h5>
                    <div class="text-muted">
                        <p>{{ $fasyankes->jenis }}</p>
                    </div>
                </div>

                <div class="pt-3">
                    <h5 class="font-size-15">Kelas :</h5>
                    <div class="text-muted">
                        <p>{{ $fasyankes->kelas }}</p>
                    </div>
                </div>

                <div class="pt-3">
                    <h5 class="font-size-15">Telp :</h5>
                    <div class="text-muted">
                        <p>{{ $fasyankes->telp }}</p>
                    </div>
                </div>

                <div class="pt-3">
                    <h5 class="font-size-15">Email :</h5>
                    <div class="text-muted">
                        <p>{{ $fasyankes->email }}</p>
                    </div>
                </div>

                <div class="pt-3">
                    <h5 class="font-size-15">Direktur :</h5>
                    <div class="text-muted">
                        <p>{{ $fasyankes->direktur }}</p>
                    </div>
                </div>

                <div class="pt-3">
                    <h5 class="font-size-15">Alamat :</h5>
                    <div class="text-muted">
                        <p>{{ $fasyankes->alamat }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <!-- end card body -->
    </div>
    <!-- end card -->
</div>

@section('script')
<script>
    window.addEventListener('openUpdateFasyankesModal', event => {
        $("#update-fasyankes").modal('show');
    })

    window.addEventListener('closeUpdateFasyankesModal', event => {
        $("#update-fasyankes").modal('hide');
    })
</script>