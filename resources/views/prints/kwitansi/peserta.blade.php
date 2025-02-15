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

        body {
            font-family: Arial, sans-serif;
            margin: 15mm;
            width: 210mm;
            height: 148mm;
            font-size: 12px;
        }
        
        .container {
            max-width: 210mm;
            padding: 10px;
            margin: 0 auto;
        }

        .header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 0;
            width: 100%;
        }

        .logo {
            width: 100px;
            height: auto;
            object-fit: contain;
            margin: 30px;
            flex-shrink: 0; /* Prevent logo from shrinking */
        }

        .header-content {
            flex: 1;
            text-align: center; /* Added center alignment */
            display: flex;
            flex-direction: column;
            align-items: center; /* Center horizontally */
        }

        .org-name {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 8px;
            background-color: #4CAF50;
            color: white;
            padding: 5px;
            border-radius: 3px;
            width: 100%;
            text-decoration: underline 1px;
            /* Removed inline-block to work with flex */
        }

        .address {
            line-height: 1.3;
            margin-bottom: 10px;
            font-size: 11px;
            text-align: center; /* Center address text */
            width: 100%;
        }

        .invoice-info {
            display: flex;
            justify-content: space-between;
            margin: 15px 0;
            font-size: 11px;
        }

        .receipt-title {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
        }

        .payment-details {
            margin: 15px 0;
            line-height: 1.8;
            font-size: 12px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .amount-in-words {
            font-style: italic;
        }

        .bank-info {
            background-color: #f5f5f5;
            padding: 10px;
            margin: 15px 0;
            border-radius: 3px;
            font-size: 11px;
        }
        .amount-footer-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            /* align-items: flex-end; */
            margin: 20px 0;
        }

        .amount-number {
            font-size: 16px;
            background-color: #f5f5f5;
            border-top: 1px solid #060606;
            border-bottom: 1px solid #060606;
            padding: 8px 15px;
            margin: 0;
            width: fit-content; /* Add this */
            display: inline-block; /* Change from flex */
        }
        
        .footer-note {
            text-align: right;
            flex-shrink: 0;
            margin-top: 0;
            display: flex;
            flex-direction: column;
            gap: 60px;
        }

        .bold {
            font-weight: bold;
        }

        .flex {
            display: flex;
            justify-content: space-between;
        }

        .payment-left {
            flex-grow: 0;     /* do not grow   - initial value: 0 */
            flex-shrink: 0;   /* do not shrink - initial value: 1 */
            flex-basis: 15em;
        }

        .payment-right {
            flex-grow: 1;     /* grow         - initial value: 1 */
            flex-shrink: 1;   /* shrink       - initial value: 1 */
            flex-basis: 0;
            text-decoration: underline black 1px;
            text-underline-offset: 4px;
        }

        .name-sign {
            text-align: center;
            text-decoration: underline black 1px;
            text-underline-offset: 4px;
        }

        .divider {
            border-top: 1px solid #000;
            margin: 0em;
        }

        @media print {
            body {
                margin: 0;
                padding: 15mm;
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
            <div class="payment-left">NO. {{ $data['order_id'] }}</div>
            <div class="receipt-title payment-right">KWITANSI</div>
        </div>

        <div class="payment-details">
            <div class="flex">
                <div class="payment-left">Telah terima dari</div>
                <div class="payment-right">: {{ $data['nama'] }}</div>
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
                <div class="name-sign">( Haris Rochmatullah, S.Kom )</div>
            </div>
        </div>
    </div>
</body>
</html>