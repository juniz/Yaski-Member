<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Template</title>
    <style>
        @page {
            size: A5 landscape;
            margin: 0;
        }

        body{
            -webkit-print-color-adjust:exact !important;
            print-color-adjust:exact !important;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            width: 210mm;
            min-height: 148mm;
            font-size: 10px;
            color: #000;
        }
        
        .container {
            width: 210mm;
            height: 148mm;
            box-sizing: border-box;
            padding: 8mm 12mm 7mm;
            margin: 0 auto;
            overflow: hidden;
        }

        .header {
            display: flex;
            align-items: center;
            gap: 12mm;
            margin-bottom: 2mm;
            width: 100%;
        }

        .logo {
            width: 25mm;
            height: auto;
            object-fit: contain;
            margin: 0 8mm 0 0;
            flex-shrink: 0;
        }

        .header-content {
            flex: 1;
            text-align: center; /* Added center alignment */
            display: flex;
            flex-direction: column;
            align-items: center; /* Center horizontally */
        }

        .org-name {
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 2mm;
            background-color: #4CAF50;
            color: white;
            padding: 2mm;
            border-radius: 2px;
            width: 100%;
            text-decoration: underline 1px;
        }

        .address {
            line-height: 1.25;
            margin-bottom: 1mm;
            font-size: 9px;
            text-align: center;
            width: 100%;
        }

        .invoice-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 2mm 0 3mm;
            font-size: 10px;
        }

        .receipt-title {
            text-align: center;
            font-weight: bold;
            font-size: 15px;
        }

        .payment-details {
            margin: 0;
            line-height: 1.45;
            font-size: 10.5px;
            display: flex;
            flex-direction: column;
            gap: 1.5mm;
        }

        .amount-in-words {
            font-style: italic;
        }

        .bank-info {
            background-color: #f5f5f5;
            padding: 3mm;
            margin: 5mm 0 4mm;
            border-radius: 2px;
            font-size: 9.5px;
        }
        .amount-footer-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin: 0;
        }

        .amount-number {
            font-size: 13px;
            font-weight: bold;
            background-color: #f5f5f5;
            border-top: 1px solid #060606;
            border-bottom: 1px solid #060606;
            padding: 3mm 6mm;
            margin: 0;
            width: 42mm;
            display: inline-block;
            text-align: center;
        }
        
        .footer-note {
            width: 58mm;
            text-align: center;
            flex-shrink: 0;
            margin-top: 0;
            display: flex;
            flex-direction: column;
            gap: 1.5mm;
            align-items: center;
            font-size: 9.5px;
        }

        .signature-qr {
            width: 28mm;
            height: 28mm;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            position: relative;
        }

        .signature-qr svg {
            width: 28mm;
            height: 28mm;
        }

        .qr-logo {
            position: absolute;
            left: 50%;
            top: 50%;
            width: 5mm;
            height: 5mm;
            padding: 0.5mm;
            object-fit: contain;
            background: #fff;
            border-radius: 1mm;
            transform: translate(-50%, -50%);
        }

        .bold {
            font-weight: bold;
        }

        .flex {
            display: flex;
            justify-content: space-between;
        }

        .payment-left {
            flex-grow: 0;
            flex-shrink: 0;
            flex-basis: 42mm;
        }

        .payment-right {
            flex-grow: 1;     /* grow         - initial value: 1 */
            flex-shrink: 1;   /* shrink       - initial value: 1 */
            flex-basis: 0;
            text-decoration: underline black 1px;
            text-underline-offset: 2px;
            overflow-wrap: anywhere;
        }

        .name-sign {
            text-align: center;
            text-decoration: underline black 1px;
            text-underline-offset: 2px;
        }

        .divider {
            border-top: 1px solid #000;
            margin: 0em;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <!-- Add your company logo here -->
            <img src="{{ $logo }}" alt="Company Logo" class="logo">
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
            <div class="payment-left">NO. {{ $data['no_kwitansi'] ?? $data['order_id'] }}</div>
            <div class="receipt-title payment-right">KWITANSI</div>
        </div>

        @if(!empty($data['no_urut_sertifikat']))
            <div class="payment-details" style="margin-bottom: 2mm;">
                <div class="flex">
                    <div class="payment-left">No. Urut Sertifikat</div>
                    <div class="payment-right">: {{ $data['no_urut_sertifikat'] }}</div>
                </div>
            </div>
        @endif

        <div class="payment-details">
            <div class="flex">
                <div class="payment-left">Telah terima dari</div>
                <div class="payment-right">: {{ $data['penerima'] ?? $data['nama'] }}</div>
            </div>

            <div class="flex">
                <div class="payment-left">Uang sejumlah</div>
                <div class="payment-right">: # {{ Str::upper($data['terbilang']) }} RUPIAH #</div>
            </div>

            <div class="flex">
                <div class="payment-left">Untuk Pembayaran</div>
                <div class="payment-right">: {{ Str::upper($data['workshop']) }} a/n {{ Str::upper($data['nama']) }} Di {{ Str::upper($data['lokasi']) }}, {{ $data['tgl_mulai'] }} - {{ $data['tgl_selesai'] }}</div>
            </div>
        </div>

        <div class="bank-info">
            Bank BNI No.Rek. 0714514494 a.n. Yayasan SIMRS Khanza Indonesia
        </div>

        <div class="amount-footer-container">
            <div class="amount-number">
                Rp {{ number_format($data['harga'], 0, ',', '.') }}
            </div>
            
            <div class="footer-note">
                <div>Kabupaten Kuningan, Jawa Barat</div>
                @if(!empty($qr))
                    <div class="signature-qr">
                        {!! $qr !!}
                        @if(!empty($logo))
                            <img src="{{ $logo }}" alt="Yaski" class="qr-logo">
                        @endif
                    </div>
                @endif
                <div class="name-sign">( Haris Rochmatullah, S.Kom )</div>
            </div>
        </div>
    </div>
    @if(!empty($print))
        <script>
            window.addEventListener('load', function () {
                window.print();
            });
        </script>
    @endif
</body>
</html>
