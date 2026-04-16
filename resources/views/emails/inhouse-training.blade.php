<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Inhouse Training</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6;">
    <p>Yth. {{ $requestInhouse->user->fasyankes->nama ?? $requestInhouse->user->name ?? 'Bapak/Ibu' }},</p>

    <p>
        Surat balasan dan surat tugas untuk kegiatan
        <strong>{{ $requestInhouse->nama_kegiatan ?? 'Inhouse Training' }}</strong>
        telah diterbitkan.
    </p>

    <p>
        Validasi surat balasan:<br>
        <a href="{{ route('inhouse-training.surat.validasi', ['requestInhouse' => $requestInhouse->id, 'type' => 'balasan']) }}">
            {{ route('inhouse-training.surat.validasi', ['requestInhouse' => $requestInhouse->id, 'type' => 'balasan']) }}
        </a>
    </p>

    <p>
        Validasi surat tugas:<br>
        <a href="{{ route('inhouse-training.surat.validasi', ['requestInhouse' => $requestInhouse->id, 'type' => 'tugas']) }}">
            {{ route('inhouse-training.surat.validasi', ['requestInhouse' => $requestInhouse->id, 'type' => 'tugas']) }}
        </a>
    </p>

    <p>Dokumen PDF juga kami lampirkan pada email ini.</p>

    <p>Terima kasih.</p>
</body>
</html>
