<div wire:init='getRequestInhouse'>
    @if($requestsInhouse && $requestsInhouse->count())
        <div class="activity-wid">
            @foreach($requestsInhouse as $requestInhouse)
                @php
                    $isApproved = $requestInhouse->stts == 'disetujui';
                    $isRejected = $requestInhouse->stts == 'ditolak';
                    $statusClass = $isApproved ? 'success' : ($isRejected ? 'danger' : 'warning');
                    $statusIcon = $isApproved ? 'mdi-check-circle-outline' : ($isRejected ? 'mdi-close-circle-outline' : 'mdi-clock-outline');
                    $statusText = $isApproved ? 'Disetujui' : ($isRejected ? 'Ditolak' : 'Diproses');
                @endphp

                <div class="activity-list activity-border">
                    <div class="activity-icon avatar-sm">
                        <span class="avatar-title bg-{{ $statusClass }} rounded-circle">
                            <i class="mdi {{ $statusIcon }} font-size-16"></i>
                        </span>
                    </div>
                    <div class="timeline-list-item">
                        <div class="d-flex">
                            <div class="flex-grow-1 overflow-hidden me-4">
                                <h5 class="font-size-14 mb-1">{{ $requestInhouse->nama_kegiatan ?? 'Inhouse Training' }}</h5>
                                <p class="text-muted mb-1">No. Surat: {{ $requestInhouse->no_surat }}</p>
                                <p class="text-muted mb-0">Tanggal Surat: {{ date('d-m-Y', strtotime($requestInhouse->tgl_surat)) }}</p>
                            </div>
                            <div class="flex-shrink-0 text-end">
                                <span class="badge bg-{{ $statusClass }} font-size-11">{{ $statusText }}</span>
                                <p class="text-muted font-size-12 mt-2 mb-0">{{ $requestInhouse->created_at->format('d-m-Y H:i') }}</p>
                            </div>
                        </div>

                        @if($isRejected)
                            <div class="alert alert-danger mt-3 mb-0" role="alert">
                                {{ $requestInhouse->alasan }}
                            </div>
                        @elseif($isApproved)
                            <button type="button" class="btn btn-sm btn-primary waves-effect waves-light mt-3" data-bs-toggle="modal" data-bs-target="#detail-inhouse-training-modal-{{ $requestInhouse->id }}">
                                <i class="bx bx-file"></i> Detail Permintaan
                            </button>
                        @else
                            <div class="alert alert-warning mt-3 mb-0" role="alert">
                                Permintaan inhouse training sedang diproses admin.
                            </div>
                        @endif
                    </div>
                </div>

                <div wire:ignore.self id="detail-inhouse-training-modal-{{ $requestInhouse->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
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
                                    Surat balasan belum diunggah admin.
                                </div>
                                @endif

                                @if($requestInhouse->file_tugas)
                                <h6 class="mt-4">Surat Tugas</h6>
                                <iframe src="{{ asset('storage/inhouse-training-tugas/'. $requestInhouse->file_tugas) }}" width="100%" height="600px" frameborder="0"></iframe>
                                @endif
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <h6 class="text-center">Belum ada permintaan inhouse training</h6>
    @endif
</div>
