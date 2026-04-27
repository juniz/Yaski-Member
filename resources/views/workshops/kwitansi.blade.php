@extends('layouts.master')

@section('title')
Kwitansi Workshop
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Workshop @endslot
@slot('title') KWITANSI @endslot
@endcomponent
@component('components.alert')@endcomponent

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="bx bx-receipt"></i> Kwitansi Workshop
                </h5>
                <div class="btn-group">
                    <button type="button" class="btn btn-success btn-sm js-download-bulk-kwitansi">
                        <i class="bx bx-download"></i> Download Semua PDF
                    </button>
                    <a href="{{ route('workshop.peserta', $id) }}" class="btn btn-secondary btn-sm">
                        <i class="bx bx-arrow-back"></i> Peserta
                    </a>
                </div>
            </div>
            <div class="card-body p-4">
                <livewire:kwitansi-table :id-workshop="$id" />
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script>
    (function () {
        const csrfToken = @json(csrf_token());
        const downloadStartUrl = @json(route('workshop.kwitansi.download-pdf.start', $id));
        const downloadProcessUrl = @json(route('workshop.kwitansi.download-pdf.process', $id));

        function buildDownloadProgressHtml(progress) {
            return `
                <div class="text-start">
                    <div class="mb-2"><strong>Status:</strong> ${progress.message || 'Sedang menyiapkan PDF kwitansi...'}</div>
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
                throw new Error(data.message || 'Terjadi kesalahan saat menyiapkan PDF kwitansi');
            }

            return data;
        }

        async function runBulkDownloadProcess() {
            let progress = await postJsonWithoutBody(downloadStartUrl);

            await Swal.fire({
                title: 'Menyiapkan PDF Kwitansi',
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

        const downloadBulkButton = document.querySelector('.js-download-bulk-kwitansi');
        if (downloadBulkButton) {
            downloadBulkButton.addEventListener('click', async function () {
                const confirmation = await Swal.fire({
                    icon: 'question',
                    title: 'Download Semua Kwitansi',
                    text: 'Siapkan dan unduh semua kwitansi dalam satu file PDF?',
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
                        text: error.message || 'Terjadi kesalahan saat menyiapkan PDF kwitansi',
                    });
                }
            });
        }
    })();
</script>
@endsection
