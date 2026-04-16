@php
    $bulan = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
    ];
    $tanggal = \Carbon\Carbon::parse($dataSurat['tanggal_surat']);
    $tanggalSurat = $tanggal->format('d') . ' ' . $bulan[(int) $tanggal->format('m')] . ' ' . $tanggal->format('Y');
    $pemohon = $dataSurat['manual_fasyankes'] ?? $requestInhouse->user->fasyankes->nama ?? $requestInhouse->user->name ?? '-';
@endphp
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page { margin: 30px 54px 28px 54px; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #000; line-height: 1.6; }
        .letterhead { width: 100%; border-collapse: collapse; }
        .logo-cell { width: 95px; vertical-align: middle; }
        .logo { width: 82px; }
        .brand-cell { background: #6f6f6f; color: #fff; padding: 9px 12px; line-height: 1.2; }
        .brand-title { font-size: 16px; font-weight: bold; letter-spacing: .5px; }
        .letterhead-line { border-top: 5px solid #8a8a8a; margin-top: 5px; margin-bottom: 14px; }
        table.meta td { padding: 0 4px 0 0; vertical-align: top; }
        .content { text-align: justify; margin-top: 18px; }
        .signature { width: 250px; margin-left: auto; margin-top: 24px; text-align: left; }
        .signature-name { font-weight: bold; text-decoration: underline; }
        .signature-title { font-style: italic; }
        .qr-code { width: 74px; height: 74px; margin: 6px 0; }
        .bold { font-weight: bold; }
    </style>
</head>
<body>
    @include('prints.inhouse-training.partials.header')

    <table class="meta">
        <tr><td style="width: 70px;">Nomor</td><td>: {{ $dataSurat['no_surat_balasan'] }}</td></tr>
        <tr><td>Lampiran</td><td>: 1</td></tr>
        <tr><td>Hal</td><td>: {{ $dataSurat['perihal'] }}</td></tr>
    </table>

    <p style="margin-top: 22px;">
        <strong>Kepada Yth.</strong><br>
        <strong>{{ $dataSurat['kepada'] }}</strong><br>
        Di<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tempat
    </p>

    <div class="content">
        <p>Dengan hormat,</p>
        @if(empty($requestInhouse->file))
        <p>
            Sehubungan dengan permintaan pendampingan <span class="bold">{{ $requestInhouse->nama_kegiatan ?? $dataSurat['perihal'] }}</span>,
            maka dengan ini kami sampaikan bahwa kami bersedia menugaskan perwakilan dari Yayasan SIMRS Khanza Indonesia
            dengan jadwal <span class="bold">{{ $dataSurat['bulan_kegiatan'] }}</span> dan susunan petugas
            sebagaimana terlampir pada surat tugas.
        </p>
        @else
        <p>
            Sehubungan adanya surat masuk dengan nomor <span class="bold">{{ $requestInhouse->no_surat }}</span>
            dengan perihal {{ $requestInhouse->nama_kegiatan ?? $dataSurat['perihal'] }}, maka dengan ini kami
            sampaikan bahwa kami bersedia menugaskan perwakilan dari Yayasan SIMRS Khanza Indonesia
            dengan jadwal <span class="bold">{{ $dataSurat['bulan_kegiatan'] }}</span> dan susunan petugas
            sebagaimana terlampir pada surat tugas.
        </p>
        @endif
        <p>
            Dalam pelaksanaan kegiatan, transport, akomodasi, dan honor narasumber selama kegiatan dapat
            disesuaikan dengan ketentuan yang berlaku di instansi pengundang. Untuk administrasi pembayaran
            dapat dilakukan ke <span class="bold">Rekening No. 134-00-628888-7 Bank Mandiri</span> a/n
            Yayasan SIMRS Khanza Indonesia KCP Kuningan.
        </p>
        <p>Demikian surat balasan ini dibuat, atas perhatian dan kerja samanya kami ucapkan terima kasih.</p>
    </div>

    <div class="signature">
        <div>Kuningan, {{ $tanggalSurat }}</div>
        <div>Hormat kami,</div>
        @if(!empty($qrCode))
            <img src="{{ $qrCode }}" class="qr-code" alt="QR Validasi">
        @else
            <br><br><br>
        @endif
        <div class="signature-name">KUSMANTO LESMANA, SE, MMRS, CPS</div>
        <div class="signature-title">Ketua Yayasan SIMRS Khanza Indonesia</div>
    </div>
</body>
</html>
