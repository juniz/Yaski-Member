<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kwitansi Workshop</title>
    <style>
        @page {
            size: 595.28pt 419.53pt;
            margin: 0;
        }

        html {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 10px;
            color: #000;
        }

        .receipt-page {
            width: 182mm;
            box-sizing: border-box;
            padding: 8mm 0 7mm;
            margin: 0 auto;
            overflow: hidden;
            position: relative;
        }

        .certificate-order {
            font-size: 6px;
            line-height: 1;
            position: absolute;
            top: 2mm;
            left: 1.5mm;
            text-align: left;
            color: #777;
        }

        .receipt-page + .receipt-page {
            page-break-before: always;
        }

        .header {
            display: table;
            width: 100%;
            margin-bottom: 1.5mm;
        }

        .logo-wrap {
            display: table-cell;
            width: 32mm;
            vertical-align: middle;
        }

        .logo {
            width: 23mm;
            height: auto;
            object-fit: contain;
        }

        .header-content {
            display: table-cell;
            text-align: center;
            vertical-align: middle;
        }

        .org-name {
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 1.5mm;
            background-color: #4CAF50;
            color: white;
            padding: 1.5mm;
            border-radius: 2px;
            text-decoration: underline;
        }

        .address {
            line-height: 1.25;
            margin-bottom: 0.5mm;
            font-size: 8.5px;
            text-align: center;
        }

        .divider {
            border-top: 1px solid #000;
            margin: 0;
        }

        .invoice-info {
            display: table;
            width: 100%;
            margin: 1.5mm 0 2mm;
            font-size: 10px;
        }

        .receipt-number {
            display: table-cell;
            width: 38mm;
        }

        .receipt-title {
            display: table-cell;
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            text-decoration: underline;
        }

        .payment-row {
            display: table;
            width: 100%;
            margin-bottom: 1.2mm;
            line-height: 1.35;
            font-size: 9.8px;
        }

        .payment-left {
            display: table-cell;
            width: 38mm;
            vertical-align: top;
        }

        .payment-right {
            display: table-cell;
            vertical-align: top;
            text-decoration: underline;
            line-height: 1.45;
            word-break: break-word;
            overflow-wrap: break-word;
            white-space: normal;
            max-width: 144mm;
        }

        .bank-info {
            background-color: #f5f5f5;
            padding: 2.5mm;
            margin: 4mm 0 3mm;
            border-radius: 2px;
            font-size: 9px;
        }

        .amount-footer-container {
            display: table;
            width: 100%;
        }

        .amount-wrap {
            display: table-cell;
            vertical-align: top;
        }

        .amount-number {
            font-size: 12px;
            font-weight: bold;
            background-color: #f5f5f5;
            border-top: 1px solid #060606;
            border-bottom: 1px solid #060606;
            padding: 2.5mm 5mm;
            width: 38mm;
            text-align: center;
        }

        .footer-note {
            display: table-cell;
            width: 50mm;
            text-align: center;
            vertical-align: top;
            font-size: 9px;
        }

        .qr-code {
            width: 25mm;
            height: 25mm;
            margin: 1mm auto;
            display: block;
        }

        .name-sign {
            text-align: center;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    @foreach($receipts as $receipt)
        @php($data = $receipt['data'])
        <div class="receipt-page">
            @if(!empty($data['no_urut_sertifikat']))
                <div class="certificate-order">
                    No. Urut: {{ $data['no_urut_sertifikat'] }}
                </div>
            @endif

            <div class="header">
                <div class="logo-wrap">
                    @if(!empty($logo))
                        <img src="{{ $logo }}" alt="Company Logo" class="logo">
                    @endif
                </div>
                <div class="header-content">
                    <div class="org-name">YAYASAN SIMRS KHANZA INDONESIA</div>
                    <div class="address">
                        PERUMAHAN BUNGALESTARI BLOK D.15 RT/RW 016/005<br>
                        DESA KEDUNGARUM KEC./KAB.KUNINGAN.PROVINSI JAWA BARAT<br>
                        NO.BADAN HUKUM: AHU-0017373.AH01.04.Tahun 2017<br>
                        HP: +6282138143546<br>
                        email: aski.khanzaindonesia@gmail.com, website: www.yaski.or.id
                    </div>
                </div>
            </div>

            <hr class="divider">

            <div class="invoice-info">
                <div class="receipt-number">NO. {{ $data['no_kwitansi'] ?? $data['order_id'] }}</div>
                <div class="receipt-title">KWITANSI</div>
            </div>

            <div class="payment-row">
                <div class="payment-left">Telah terima dari</div>
                <div class="payment-right">: {{ $data['penerima'] ?? $data['nama'] }}</div>
            </div>

            <div class="payment-row">
                <div class="payment-left">Uang sejumlah</div>
                <div class="payment-right">: # {{ Str::upper($data['terbilang']) }} RUPIAH #</div>
            </div>

            <div class="payment-row">
                <div class="payment-left">Untuk Pembayaran</div>
                <div class="payment-right">: {{ Str::upper($data['workshop']) }} a/n {{ Str::upper($data['nama']) }} Di {{ Str::upper($data['lokasi']) }}, {{ $data['tgl_mulai'] }} - {{ $data['tgl_selesai'] }}</div>
            </div>

            <div class="bank-info">
                Bank BNI No.Rek. 0714514494 a.n. Yayasan SIMRS Khanza Indonesia
            </div>

            <div class="amount-footer-container">
                <div class="amount-wrap">
                    <div class="amount-number">
                        Rp {{ number_format($data['harga'], 0, ',', '.') }}
                    </div>
                </div>

                <div class="footer-note">
                    <div>Kabupaten Kuningan, Jawa Barat</div>
                    <img src="{{ $receipt['qr'] }}" class="qr-code" alt="QR Validasi">
                    <div class="name-sign">( Haris Rochmatullah, S.Kom )</div>
                </div>
            </div>
        </div>
    @endforeach
</body>
</html>
