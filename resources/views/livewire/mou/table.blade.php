<div class="card">
    <div class="card-body">
        <div class="d-flex flex-row-reverse" style="gap: 10px">
            <div class="col-md-5">
                <div class="d-flex flex-row gap-2">
                    <div class="col-md-4">
                        <select id="jenis" wire:model='jenis' class="form-control" name="jenis">
                            <option value="all">Semua</option>
                            <option value="menunggu">Menunggu</option>
                            <option value="disetujui">Disetujui</option>
                            <option value="ditolak">Ditolak</option>
                        </select>
                    </div>
                    <div class="col-md-8">
                        <input type="text" placeholder="Cari....." wire:model.debounce.500ms='search' class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive mt-2">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fasyankes</th>
                        <th>No Surat</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mous as $mou)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $mou->user->fasyankes->nama }}</td>
                        <td>{{ $mou->no_surat }}</td> 
                        <td>
                            @if($mou->stts == 'disetujui')
                            <button wire:click='$emit("docPersetujuan", {{$mou}})' class="btn btn-sm btn-success"><i class="bx bx-file"></i> {{ $mou->stts }}</button>
                            @elseif($mou->stts == 'ditolak')
                            <span class="badge bg-danger text-white font-size-11"><i class="bx bx-window-close"></i> {{ $mou->stts }}</span>
                            @else
                            <a class="badge bg-warning text-dark font-size-11"><i class="bx bx-right-arrow-alt"></i> {{ $mou->stts }}</a>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group">
                                <button type="button" wire:key='edit-{{$mou->id}}'
                                    wire:click='$emit("modalPersetujuan", {{$mou}})' class="btn btn-sm btn-success"><i
                                        class="bx bx-edit"></i></button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td class="text-center" colspan="5">
                            <h6>Data Tidak ada</h6>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex flex-row">
                <div class="mx-auto">
                    {{ $mous->links() }}
                </div>
            </div>
        </div>
    </div>  
</div>