<div>
    <div wire:init="getRequestInhouse" class="card">
        <div class="card-body">
            <h5 class="card-title">Riwayat Inhouse Training</h5>
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kegiatan</th>
                            <th>No Surat</th>
                            <th>Tanggal Surat</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requestsInhouse ?? [] as $requestInhouse)
                            @php
                                $isApproved = $requestInhouse->stts == 'disetujui';
                                $isRejected = $requestInhouse->stts == 'ditolak';
                                $statusClass = $isApproved ? 'success' : ($isRejected ? 'danger' : 'warning');
                                $statusText = $isApproved ? 'Disetujui' : ($isRejected ? 'Ditolak' : 'Diproses');
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $requestInhouse->nama_kegiatan ?? 'Inhouse Training' }}</td>
                                <td>{{ $requestInhouse->no_surat }}</td>
                                <td>{{ date('d-m-Y', strtotime($requestInhouse->tgl_surat)) }}</td>
                                <td>
                                    <span class="badge bg-{{ $statusClass }}">{{ $statusText }}</span>
                                    @if($isRejected && $requestInhouse->alasan)
                                        <div class="text-danger font-size-12 mt-2">{{ $requestInhouse->alasan }}</div>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($isApproved)
                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#profile-detail-inhouse-training-modal-{{ $requestInhouse->id }}">
                                            <i class="bx bx-file me-1"></i> Detail
                                        </button>
                                    @elseif($requestInhouse->file)
                                        <a href="{{ asset('storage/inhouse-training/'. $requestInhouse->file) }}" target="_blank" class="btn btn-outline-secondary btn-sm waves-effect waves-light">
                                            <i class="bx bx-show me-1"></i> Lihat Surat
                                        </a>
                                    @else
                                        <span class="badge bg-soft-info text-info">Manual Admin</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada riwayat inhouse training</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @foreach($requestsInhouse ?? [] as $requestInhouse)
        @if($requestInhouse->stts == 'disetujui')
            <div wire:ignore.self id="profile-detail-inhouse-training-modal-{{ $requestInhouse->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Detail {{ $requestInhouse->nama_kegiatan ?? 'Inhouse Training' }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <h6>Surat Permintaan</h6>
                            @if($requestInhouse->file)
                                <iframe src="{{ asset('storage/inhouse-training/'. $requestInhouse->file) }}" width="100%" height="600px" frameborder="0"></iframe>
                            @else
                                <div class="alert alert-info" role="alert">
                                    Permintaan ini dibuat manual oleh admin tanpa upload surat permintaan.
                                </div>
                            @endif

                            @if($requestInhouse->file_balasan)
                                <h6 class="mt-4">Surat Balasan</h6>
                                <iframe src="{{ asset('storage/inhouse-training-balasan/'. $requestInhouse->file_balasan) }}" width="100%" height="600px" frameborder="0"></iframe>
                            @else
                                <div class="alert alert-info mt-4" role="alert">
                                    Surat balasan belum tersedia.
                                </div>
                            @endif

                            @if($requestInhouse->file_tugas)
                                <h6 class="mt-4">Surat Tugas</h6>
                                <iframe src="{{ asset('storage/inhouse-training-tugas/'. $requestInhouse->file_tugas) }}" width="100%" height="600px" frameborder="0"></iframe>
                            @else
                                <div class="alert alert-info mt-4" role="alert">
                                    Surat tugas belum tersedia.
                                </div>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</div>
