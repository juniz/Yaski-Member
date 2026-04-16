@php
    $bulan = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
    ];
    $tanggal = \Carbon\Carbon::parse($dataSurat['tanggal_surat']);
    $tanggalSurat = $tanggal->format('d') . ' ' . $bulan[(int) $tanggal->format('m')] . ' ' . $tanggal->format('Y');
@endphp
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page { margin: 30px 54px 28px 54px; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #000; line-height: 1.45; }
        .letterhead { width: 100%; border-collapse: collapse; }
        .logo-cell { width: 95px; vertical-align: middle; }
        .logo { width: 82px; }
        .brand-cell { background: #6f6f6f; color: #fff; padding: 9px 12px; line-height: 1.2; }
        .brand-title { font-size: 16px; font-weight: bold; letter-spacing: .5px; }
        .letterhead-line { border-top: 5px solid #8a8a8a; margin-top: 5px; margin-bottom: 14px; }
        .title { text-align: center; font-weight: bold; text-decoration: underline; font-size: 15px; margin-top: 8px; }
        .number { text-align: center; margin-bottom: 22px; }
        table.info td { padding: 1px 4px; vertical-align: top; }
        table.budget { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.budget th, table.budget td { border: 1px solid #000; padding: 3px 6px; vertical-align: top; }
        table.budget th { text-align: center; font-weight: bold; }
        .signature { width: 250px; margin-left: auto; margin-top: 20px; text-align: left; }
        .signature-name { font-weight: bold; text-decoration: underline; }
        .signature-title { font-style: italic; }
        .qr-code { width: 74px; height: 74px; margin: 6px 0; }
        .bold { font-weight: bold; }
    </style>
</head>
<body>
    @include('prints.inhouse-training.partials.header')

    <div class="title">SURAT TUGAS</div>
    <div class="number">Nomor : {{ $dataSurat['no_surat_tugas'] }}</div>

    <p>Yang bertanda tangan dibawah ini :</p>
    <table class="info">
        <tr><td style="width: 110px;">Nama</td><td>: KUSMANTO LESMANA, SE, MMRS</td></tr>
        <tr><td>Jabatan</td><td>: Ketua Yayasan SIMRS Khanza Indonesia</td></tr>
        <tr><td>Alamat</td><td>: Jl. Ir. H.Juanda No. 207 Kuningan Jawa Barat</td></tr>
    </table>

    <p style="margin-top: 18px;">Memberikan tugas kepada :</p>
    <table class="info">
        @foreach($dataSurat['petugas'] as $index => $petugas)
        <tr>
            <td style="width: 110px;">{{ $index === 0 ? 'Nama' : '' }}</td>
            <td>: {{ $index + 1 }}. {{ $petugas['nama'] }}{{ !empty($petugas['kontak']) ? ' (' . $petugas['kontak'] . ')' : '' }}</td>
        </tr>
        @endforeach
        <tr><td>Kegiatan</td><td>: {{ $requestInhouse->nama_kegiatan ?? $dataSurat['perihal'] }}</td></tr>
    </table>

    <p style="text-align: justify;">
        Demikian surat tugas ini dibuat agar dapat dipergunakan sebagaimana mestinya. Mohon bisa dijadikan
        pedoman sebagai dasar administrasi, serta tujuan pembayaran administrasi honorarium narasumber
        setelah kegiatan ke <span class="bold">No. 134-00-628888-7 Bank Mandiri</span> a/n Yayasan SIMRS Khanza Indonesia KCP Kuningan.
    </p>

    <table class="budget">
        <thead>
            <tr>
                <th style="width: 28px;">No</th>
                <th>Kegiatan</th>
                <th style="width: 35px;">Jml</th>
                <th style="width: 35px;">Sat</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            <tr><td style="text-align:center;">1.</td><td>Transportasi</td><td style="text-align:center;">{{ count($dataSurat['petugas']) }}</td><td>Org</td><td>{{ $dataSurat['transport_nominal'] }}</td></tr>
            <tr><td style="text-align:center;">2.</td><td>Penginapan</td><td style="text-align:center;">{{ count($dataSurat['petugas']) }}</td><td>Org</td><td>{{ $dataSurat['penginapan_nominal'] }}</td></tr>
            <tr><td style="text-align:center;">3.</td><td>Honor Narasumber</td><td style="text-align:center;">{{ count($dataSurat['petugas']) }}</td><td>Org</td><td>{{ $dataSurat['honor_nominal'] }}</td></tr>
        </tbody>
    </table>

    <div class="signature">
        @if(!empty($qrCode))
            <img src="{{ $qrCode }}" class="qr-code" alt="QR Validasi">
        @else
            <br>
        @endif
        <div class="signature-name">KUSMANTO LESMANA, SE, MMRS, CPS</div>
        <div class="signature-title">Ketua Yayasan SIMRS Khanza Indonesia</div>
    </div>
</body>
</html>
