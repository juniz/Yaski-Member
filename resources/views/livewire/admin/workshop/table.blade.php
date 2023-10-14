<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-4">
                    <div class="d-flex flex-row justify-content-end mb-2">
                        <div class="text-sm-end">
                            <button type="button" wire:click='$emit("createModal")'
                                class="btn btn-sm btn-secondary btn-rounded waves-effect waves-light me-2"><i
                                    class="mdi mdi-plus me-1"></i> Tambah </button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Gambar</th>
                                    <th>Tgl Mulai</th>
                                    <th>Tgl Selesai</th>
                                    <th>Menu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($workshops as $workshop)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $workshop->nama }}</td>
                                    <td><img src="{{ asset('/storage/workshop/'.$workshop->gambar) }}" alt=""
                                            style="width: 200px">
                                    </td>
                                    <td>{{ $workshop->tgl_mulai }}</td>
                                    <td>{{ $workshop->tgl_selesai }}</td>
                                    <td></td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="text-center" colspan="6">
                                        <h6>Data Tidak ada</h6>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>