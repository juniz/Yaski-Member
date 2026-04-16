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
                        <th>Kegiatan</th>
                        <th>No Surat</th>
                        <th>Tanggal Surat</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $request)
                    @php
                        $fasyankes = $request->user->fasyankes ?? null;
                        $email = $fasyankes->email ?? $request->user->email ?? '';
                        $phone = preg_replace('/[^0-9]/', '', $fasyankes->telp ?? '');
                        if (substr($phone, 0, 1) === '0') {
                            $phone = '62' . substr($phone, 1);
                        }
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $request->user->fasyankes->nama ?? $request->user->name ?? '-' }}</td>
                        <td>{{ $request->nama_kegiatan ?? '-' }}</td>
                        <td>{{ $request->no_surat }}</td>
                        <td>{{ date('d-m-Y', strtotime($request->tgl_surat)) }}</td>
                        <td>
                            @if($request->stts == 'disetujui')
                            <span class="badge bg-success text-white font-size-11"><i class="bx bx-check"></i> {{ $request->stts }}</span>
                            @elseif($request->stts == 'ditolak')
                            <span class="badge bg-danger text-white font-size-11"><i class="bx bx-window-close"></i> {{ $request->stts }}</span>
                            @else
                            <span class="badge bg-warning text-dark font-size-11"><i class="bx bx-right-arrow-alt"></i> {{ $request->stts }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex flex-wrap gap-1">
                                <button type="button" wire:key='view-{{$request->id}}'
                                    wire:click='$emit("docInhouseTraining", {{$request}})' class="btn btn-sm btn-primary">
                                    <i class="bx bx-file"></i> Lihat Surat
                                </button>
                                @if($request->stts == 'disetujui')
                                <button type="button" wire:key='edit-surat-{{$request->id}}'
                                    wire:click='$emit("editSuratInhouseTraining", {{$request}})' class="btn btn-sm btn-warning">
                                    <i class="bx bx-edit-alt"></i> Edit Surat
                                </button>
                                <button type="button" wire:click='kirimEmail({{ $request->id }})'
                                    class="btn btn-sm btn-info" {{ $email ? '' : 'disabled' }}>
                                    <i class="bx bx-envelope"></i> Kirim Email
                                </button>
                                <button type="button" wire:click='kirimWa({{ $request->id }})'
                                    class="btn btn-sm btn-success" {{ $phone ? '' : 'disabled' }}>
                                    <i class="bx bxl-whatsapp"></i> Kirim WA
                                </button>
                                @else
                                <button type="button" wire:key='edit-{{$request->id}}'
                                    wire:click='$emit("modalInhouseTraining", {{$request}})' class="btn btn-sm btn-success">
                                    <i class="bx bx-edit"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td class="text-center" colspan="7">
                            <h6>Data Tidak ada</h6>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex flex-row">
                <div class="mx-auto">
                    {{ $requests->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
