<div>
    <div wire:init='getWorkshop' class="card">
        <div class="card-body">
            <h5 class="card-title">Riwayat Workshop</h5>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Workshop</th>
                            <th>Peserta</th>
                            <th>Biaya</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $transaction->workshop->nama }}</td>
                            <td>
                                <ul class="mb-0">
                                    @foreach($transaction->peserta as $peserta)
                                    <li><small>{{ $peserta->nama }}</small></li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                <ul class="mb-0 px-2" style="list-style: none;">
                                    @foreach($transaction->peserta as $peserta)
                                    <li><small><strong>{{ $peserta->paket }}</strong>: {{ number_format($peserta->harga, 0, ',', '.') }}</small></li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="text-center">
                                <div class="d-flex flex-wrap justify-content-center gap-1">
                                    @if($transaction->workshop->materials->count() > 0)
                                        <button class="btn btn-primary btn-sm waves-effect waves-light" wire:click="showMateri({{ $transaction->workshop_id }})">
                                            <i class="bx bx-book-open me-1"></i> Materi
                                        </button>
                                    @else
                                        <span class="badge bg-soft-secondary text-secondary">Tidak ada materi</span>
                                    @endif
                                    <button class="btn btn-success btn-sm waves-effect waves-light" wire:click="showSertifikat('{{ $transaction->id }}')">
                                        <i class="bx bx-medal me-1"></i> Sertifikat
                                    </button>
                                    @foreach($transaction->peserta as $peserta)
                                        <a href="{{ route('kwitansi.cetak', $peserta->id) }}" target="_blank" class="btn btn-outline-success btn-sm waves-effect waves-light">
                                            <i class="bx bx-receipt me-1"></i> Kwitansi {{ $loop->iteration }}
                                        </a>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Materi -->
    <div wire:ignore.self class="modal fade" id="materiModal" tabindex="-1" aria-labelledby="materiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="materiModalLabel">
                        <i class="bx bx-book-content me-2"></i> Materi Workshop: {{ $selectedWorkshop->nama ?? '' }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    @if($selectedWorkshop && $selectedWorkshop->materials->count() > 0)
                        <div class="row g-3">
                            @foreach($selectedWorkshop->materials as $materi)
                                <div class="col-md-6">
                                    <div class="card h-100 border shadow-sm">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="avatar-sm me-3">
                                                    <span class="avatar-title rounded-circle {{ $materi->type == 'file' ? 'bg-soft-info text-info' : 'bg-soft-warning text-warning' }}">
                                                        <i class="bx {{ $materi->type == 'file' ? 'bx-file' : 'bx-link' }} fs-4"></i>
                                                    </span>
                                                </div>
                                                <h6 class="mb-0 flex-grow-1">{{ $materi->title }}</h6>
                                            </div>
                                            <div class="d-grid">
                                                @if($materi->type == 'file')
                                                    <a href="{{ asset('storage/workshop/material/' . $materi->workshop_id . '/' . $materi->file_path) }}" target="_blank" class="btn btn-outline-info btn-sm">
                                                        <i class="bx bx-download me-1"></i> Download File
                                                    </a>
                                                @else
                                                    <a href="{{ $materi->link_url }}" target="_blank" class="btn btn-outline-warning btn-sm">
                                                        <i class="bx bx-link-external me-1"></i> Buka Link Materi
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bx bx-info-circle fs-1 text-muted mb-2"></i>
                            <p class="text-muted">Belum ada materi yang tersedia untuk workshop ini.</p>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="sertifikatModal" tabindex="-1" aria-labelledby="sertifikatModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title text-white" id="sertifikatModalLabel">
                        <i class="bx bx-medal me-2"></i> Sertifikat: {{ $selectedTransaction->workshop->nama ?? '' }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    @if($selectedSertifikats && $selectedSertifikats->count() > 0)
                        <div class="row g-3">
                            @foreach($selectedSertifikats as $sertifikat)
                                <div class="col-lg-6">
                                    <div class="card border shadow-sm h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between gap-2 mb-3">
                                                <div>
                                                    <h6 class="mb-1">{{ $sertifikat->nama ?? $sertifikat->peserta->nama ?? '-' }}</h6>
                                                    <p class="text-muted mb-0 font-size-12">{{ $sertifikat->no_sertifikat ?? '-' }}</p>
                                                </div>
                                                <span class="badge {{ $sertifikat->file_sertifikat ? 'bg-success' : 'bg-warning text-dark' }}">
                                                    {{ $sertifikat->file_sertifikat ? 'Tersedia' : 'Belum Generate' }}
                                                </span>
                                            </div>

                                            @if($sertifikat->file_sertifikat)
                                                <div class="border rounded overflow-hidden mb-3 bg-light">
                                                    <img src="{{ url('sertifikat/' . $sertifikat->id . '/preview') }}" alt="Preview Sertifikat" class="img-fluid w-100">
                                                </div>
                                                <div class="d-flex flex-wrap gap-2">
                                                    <a href="{{ url('sertifikat/' . $sertifikat->id . '/preview') }}" target="_blank" class="btn btn-outline-info btn-sm">
                                                        <i class="bx bx-show me-1"></i> Preview
                                                    </a>
                                                    <a href="{{ url('sertifikat/' . $sertifikat->id . '/download') }}" class="btn btn-outline-success btn-sm">
                                                        <i class="bx bx-download me-1"></i> Download
                                                    </a>
                                                    <a href="{{ route('sertifikat.validasi', $sertifikat->id) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                        <i class="bx bx-check-shield me-1"></i> Validasi
                                                    </a>
                                                </div>
                                            @else
                                                <div class="alert alert-warning mb-0" role="alert">
                                                    Sertifikat peserta ini belum digenerate oleh admin.
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bx bx-info-circle fs-1 text-muted mb-2"></i>
                            <p class="text-muted mb-0">Belum ada sertifikat untuk riwayat workshop ini.</p>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('openMateriModal', event => {
            var myModal = new bootstrap.Modal(document.getElementById('materiModal'));
            myModal.show();
        })
        window.addEventListener('openSertifikatModal', event => {
            var myModal = new bootstrap.Modal(document.getElementById('sertifikatModal'));
            myModal.show();
        })
    </script>
</div>
