<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        @page {
            size: 14,8cm 21cm;
            margin: 4px;
        }
        @media print {
            html, body {
                width: 14,8cm;
                height: 21cm;
                margin: 0;
                padding: 0;
            }
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        #alamat {
            font-size: 14px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        #organisasi {
            font-size: 28px;
            text-decoration: underline;
            color: white;
        }
        #kwitansi {
            font-size: 33px;
            font-weight: bold;
            text-decoration: underline;
            text-align: center;
            padding-top: 10px;
            padding-bottom: 10px;
        }
        #data {
            font-size: 18px;
            line-height: 40px;
        }

    </style>
</head>
<body>
    <table style="width:100%">
        <tr>
            <th rowspan="2" style="width: 30%">Firstname</th>
            <th colspan="2" style="background-color: rgb(146,208,81)">
                <h3 id="organisasi">YAYASAN SIMRS KHANZA INDONESIA</h3>
            </th> 
        </tr>
        <tr>
            <td colspan="2">
                <div id="alamat">
                    <span>PERUMAHAN BUNGA LESTARI BLOK D. 15 RT/RW 016/005</span>
                    <span>DESA KEDUNGARUM KEC./KAB. KUNINGAN, PROVINSI JAWA BARAT</span>
                    <span>NO. BADAN HUKUM : AHU-0017373.AH.01.04. Tahun 2017</span>
                    <span>HP : +62 82138143546</span>
                    <span>email : aski.khanzaindonesia@gmail.com, website : www.yaski.or.id</span>
                </div>
            </td>
        </tr>
        <tr>
            <td>No.</td>
            <td id="kwitansi" colspan="2">KWITANSI</td>
        </tr>
        <tr id="data">
            <td>Telah terima dari</td>
            <td>: </td>
        </tr>
        <tr id="data">
            <td>Uang sejumlah</td>
            <td>: </td>
        </tr>
        <tr id="data">
            <td>Untuk Pembayaran</td>
            <td>: </td>
        </tr>
    </table>
</body>
</html>