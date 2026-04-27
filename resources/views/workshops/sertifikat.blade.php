@extends('layouts.master')

@section('title')
Sertifikat Workshop
@endsection
@section('css')
<link href="{{ URL::asset('assets/libs/glightbox/glightbox.min.css') }}" rel="stylesheet">
@endsection

@section('content')
@component('components.alert')@endcomponent
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="bx bx-certification"></i> Sertifikat Workshop
                </h5>
                <div class="btn-group">
                    <button
                        type="button"
                        class="btn btn-primary btn-sm me-1 js-bulk-sertifikat"
                        data-mode="generate"
                        data-confirm="Generate sertifikat untuk semua peserta yang belum memiliki sertifikat?"
                    >
                        <i class="bx bx-play-circle"></i> Generate Semua
                    </button>
                    <button
                        type="button"
                        class="btn btn-warning btn-sm me-1 js-bulk-sertifikat"
                        data-mode="regenerate"
                        data-confirm="Regenerate SEMUA sertifikat? Ini akan menimpa file yang sudah ada."
                    >
                        <i class="bx bx-refresh"></i> Regenerate Semua
                    </button>
                    <button
                        type="button"
                        class="btn btn-success btn-sm me-1 js-download-bulk-pdf"
                    >
                        <i class="bx bx-download"></i> Download PDF Gabungan
                    </button>
                    <a href="{{ route('workshop.setting', $id) }}" class="btn btn-secondary btn-sm">
                        <i class="bx bx-cog"></i> Setting Template
                    </a>
                </div>
            </div>
            <div class="card-body p-4">
                <livewire:sertifikat-table :id-workshop="$id" />
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    (function () {
        const csrfToken = @json(csrf_token());
        const startUrl = @json(route('workshop.bulk-progress.start', $id));
        const processUrl = @json(route('workshop.bulk-progress.process', $id));
        const downloadStartUrl = @json(route('workshop.bulk-download.start', $id));
        const downloadProcessUrl = @json(route('workshop.bulk-download.process', $id));

        function modeLabel(mode) {
            return mode === 'regenerate' ? 'Regenerate' : 'Generate';
        }

        function buildProgressHtml(progress) {
            return `
                <div class="text-start">
                    <div class="mb-2"><strong>Status:</strong> ${progress.message || 'Sedang memproses...'}</div>
                    <div class="progress mb-3" style="height: 20px;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: ${progress.percent}%;">
                            ${progress.percent}%
                        </div>
                    </div>
                    <div class="row text-center g-2">
                        <div class="col-4"><div class="border rounded p-2"><div class="fw-bold">${progress.processed_all}</div><small>Diproses</small></div></div>
                        <div class="col-4"><div class="border rounded p-2"><div class="fw-bold text-success">${progress.success}</div><small>Berhasil</small></div></div>
                        <div class="col-4"><div class="border rounded p-2"><div class="fw-bold text-danger">${progress.failed}</div><small>Gagal</small></div></div>
                        <div class="col-6"><div class="border rounded p-2"><div class="fw-bold text-secondary">${progress.skipped}</div><small>Skip</small></div></div>
                        <div class="col-6"><div class="border rounded p-2"><div class="fw-bold">${progress.total}</div><small>Total</small></div></div>
                    </div>
                </div>
            `;
        }

        function buildDownloadProgressHtml(progress) {
            return `
                <div class="text-start">
                    <div class="mb-2"><strong>Status:</strong> ${progress.message || 'Sedang menyiapkan PDF gabungan...'}</div>
                    <div class="progress mb-3" style="height: 20px;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: ${progress.percent}%;"></div>
                    </div>
                    <div class="row text-center g-2">
                        <div class="col-4"><div class="border rounded p-2"><div class="fw-bold">${progress.processed}</div><small>Diproses</small></div></div>
                        <div class="col-4"><div class="border rounded p-2"><div class="fw-bold">${progress.total}</div><small>Total</small></div></div>
                        <div class="col-4"><div class="border rounded p-2"><div class="fw-bold text-danger">${progress.failed}</div><small>Gagal</small></div></div>
                    </div>
                </div>
            `;
        }

        async function postJson(url, payload) {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify(payload),
            });

            const data = await response.json().catch(() => ({}));
            if (!response.ok) {
                throw new Error(data.message || 'Terjadi kesalahan saat memproses bulk sertifikat');
            }

            return data;
        }

        async function postJsonWithoutBody(url) {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });

            const data = await response.json().catch(() => ({}));
            if (!response.ok) {
                throw new Error(data.message || 'Terjadi kesalahan saat menyiapkan PDF gabungan');
            }

            return data;
        }

        async function runBulkProcess(mode) {
            let progress = await postJson(startUrl, { mode });

            await Swal.fire({
                title: `${modeLabel(mode)} Sertifikat`,
                html: buildProgressHtml(progress),
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: async () => {
                    Swal.showLoading();

                    while (!progress.completed) {
                        progress = await postJson(processUrl, { mode });
                        Swal.update({
                            html: buildProgressHtml(progress),
                        });
                    }

                    Swal.hideLoading();
                    Swal.update({
                        icon: progress.failed > 0 ? 'warning' : 'success',
                        title: `${modeLabel(mode)} Selesai`,
                        html: buildProgressHtml(progress),
                        showConfirmButton: true,
                        confirmButtonText: 'Tutup',
                    });
                },
            });

            window.location.reload();
        }

        async function runBulkDownloadProcess() {
            let progress = await postJsonWithoutBody(downloadStartUrl);

            await Swal.fire({
                title: 'Menyiapkan PDF Gabungan',
                html: buildDownloadProgressHtml(progress),
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: async () => {
                    Swal.showLoading();

                    while (!progress.completed) {
                        progress = await postJsonWithoutBody(downloadProcessUrl);
                        Swal.update({
                            html: buildDownloadProgressHtml(progress),
                        });
                    }

                    Swal.hideLoading();

                    if (progress.download_ready && progress.download_url) {
                        const downloadLink = document.createElement('a');
                        downloadLink.href = progress.download_url;
                        downloadLink.style.display = 'none';
                        document.body.appendChild(downloadLink);
                        downloadLink.click();
                        downloadLink.remove();

                        Swal.update({
                            icon: progress.failed > 0 ? 'warning' : 'success',
                            title: 'PDF Siap Diunduh',
                            html: buildDownloadProgressHtml(progress),
                            showConfirmButton: true,
                            confirmButtonText: 'Tutup',
                        });
                    } else {
                        Swal.update({
                            icon: 'error',
                            title: 'Proses Gagal',
                            html: buildDownloadProgressHtml(progress),
                            showConfirmButton: true,
                            confirmButtonText: 'Tutup',
                        });
                    }
                },
            });
        }

        document.querySelectorAll('.js-bulk-sertifikat').forEach((button) => {
            button.addEventListener('click', async function () {
                const mode = this.dataset.mode;
                const confirmText = this.dataset.confirm || 'Lanjutkan proses bulk sertifikat?';

                const confirmation = await Swal.fire({
                    icon: 'question',
                    title: `${modeLabel(mode)} Sertifikat`,
                    text: confirmText,
                    showCancelButton: true,
                    confirmButtonText: 'Ya, lanjutkan',
                    cancelButtonText: 'Batal',
                });

                if (!confirmation.isConfirmed) {
                    return;
                }

                try {
                    await runBulkProcess(mode);
                } catch (error) {
                    await Swal.fire({
                        icon: 'error',
                        title: 'Proses Gagal',
                        text: error.message || 'Terjadi kesalahan saat menjalankan bulk sertifikat',
                    });
                }
            });
        });

        const downloadBulkButton = document.querySelector('.js-download-bulk-pdf');
        if (downloadBulkButton) {
            downloadBulkButton.addEventListener('click', async function () {
                const confirmation = await Swal.fire({
                    icon: 'question',
                    title: 'Download PDF Gabungan',
                    text: 'Siapkan dan unduh semua sertifikat dalam satu file PDF?',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, siapkan',
                    cancelButtonText: 'Batal',
                });

                if (!confirmation.isConfirmed) {
                    return;
                }

                try {
                    await runBulkDownloadProcess();
                } catch (error) {
                    await Swal.fire({
                        icon: 'error',
                        title: 'Proses Gagal',
                        text: error.message || 'Terjadi kesalahan saat menyiapkan PDF gabungan',
                    });
                }
            });
        }

        window.addEventListener('editNamaSertifikatAdmin', async function (event) {
            const payload = event.detail || {};
            const result = await Swal.fire({
                title: 'Edit Nama Sertifikat',
                input: 'text',
                inputValue: payload.nama || '',
                inputLabel: 'Nama yang akan tampil di sertifikat',
                inputPlaceholder: 'Masukkan nama sertifikat',
                showCancelButton: true,
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Batal',
                inputValidator: (value) => {
                    if (!value || !value.trim()) {
                        return 'Nama sertifikat wajib diisi';
                    }
                },
            });

            if (!result.isConfirmed) {
                return;
            }

            Livewire.emitTo(payload.component, 'simpanNamaSertifikat', payload.sertifikat_id, result.value);
        });
    })();
</script>
@endsection
