<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Validasi Surat Inhouse Training</title>
    <link href="{{ URL::asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/icons.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/app.min.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body p-4">
                        @if($isValid)
                            <div class="d-flex align-items-center mb-4">
                                <div class="avatar-md me-3">
                                    <span class="avatar-title bg-success rounded-circle">
                                        <i class="mdi mdi-check-decagram font-size-24"></i>
                                    </span>
                                </div>
                                <div>
                                    <h4 class="mb-1">Surat Valid</h4>
                                    <p class="text-muted mb-0">Dokumen ini tercatat sebagai surat resmi yang dikeluarkan oleh Yayasan SIMRS Khanza Indonesia.</p>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <tr>
                                        <th style="width: 220px;">Jenis Surat</th>
                                        <td>{{ $type == 'tugas' ? 'Surat Tugas' : 'Surat Balasan' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nomor Surat</th>
                                        <td>{{ $type == 'tugas' ? ($requestInhouse->data_surat['no_surat_tugas'] ?? '-') : ($requestInhouse->data_surat['no_surat_balasan'] ?? '-') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Kegiatan</th>
                                        <td>{{ $requestInhouse->nama_kegiatan ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Pemohon</th>
                                        <td>{{ $requestInhouse->user->fasyankes->nama ?? $requestInhouse->user->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Surat</th>
                                        <td>{{ !empty($requestInhouse->data_surat['tanggal_surat']) ? date('d-m-Y', strtotime($requestInhouse->data_surat['tanggal_surat'])) : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td><span class="badge bg-success">Disetujui</span></td>
                                    </tr>
                                </table>
                            </div>
                        @else
                            <div class="d-flex align-items-center">
                                <div class="avatar-md me-3">
                                    <span class="avatar-title bg-danger rounded-circle">
                                        <i class="mdi mdi-close-octagon-outline font-size-24"></i>
                                    </span>
                                </div>
                                <div>
                                    <h4 class="mb-1">Surat Tidak Valid</h4>
                                    <p class="text-muted mb-0">Data surat tidak ditemukan atau surat belum disetujui.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
