<div class="card">
    <div class="card-body">
        <div class="d-flex flex-row-reverse" style="gap: 10px">
            <div class="col-md-5">
                <div class="d-flex flex-row gap-2">
                    <div class="col-md-4">
                        <select id="jenis" wire:model='jenis' class="form-control" name="jenis">
                            <option value="all">Semua</option>
                            <option value="proses">Proses</option>
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
                    @forelse($paklarings as $paklaring)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $paklaring->fasyankes->name }}</td>
                        <td>{{ $paklaring->no_surat }}</td> 
                        <td>
                            @if($paklaring->stts == 'disetujui')
                            <button wire:click='$emit("docPersetujuan", {{$paklaring}})' class="btn btn-sm btn-success"><i class="bx bx-file"></i> {{ $paklaring->stts }}</button>
                            @elseif($paklaring->stts == 'ditolak')
                            <span class="badge bg-danger text-white font-size-11"><i class="bx bx-window-close"></i> {{ $paklaring->stts }}</span>
                            @else
                            <a class="badge bg-warning text-dark font-size-11"><i class="bx bx-right-arrow-alt"></i> {{ $paklaring->stts }}</a>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group">
                                <button type="button" wire:key='edit-{{$paklaring->id}}'
                                    wire:click='$emit("modalPersetujuan", {{$paklaring}})' class="btn btn-sm btn-success"><i
                                        class="bx bx-edit"></i></button>
                                {{-- <button type="button" wire:key='user-{{$paklaring->id}}'
                                    wire:click='$emit("openModalUser", {{$paklaring->id}})' class="btn btn-sm btn-secondary"><i
                                        class="bx bx-user"></i></button>
                                <button type="button" wire:key='permission-{{$paklaring->id}}'
                                    wire:click='$emit("openModalPermission", {{$paklaring->id}})'
                                    class="btn btn-sm btn-primary"><i class="bx bx-lock"></i></button>
                                <button type="button" wire:key='delete-{{$paklaring->id}}'
                                    wire:click='openDialog("{{$paklaring->id}}}}")' class="btn btn-sm btn-danger"><i
                                        class="bx bx-trash"></i></button> --}}
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
                    {{ $paklarings->links() }}
                </div>
            </div>
        </div>
    </div>  
</div>