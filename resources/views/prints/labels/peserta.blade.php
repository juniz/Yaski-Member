<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Label Print</title>
    <style>
        @page {
            size: 10cm 5cm;
            margin: 4px;
        }
        @media print {
            html, body {
                width: 10cm;
                height: 5cm;
                margin: 0;
                padding: 0;
            }
        }
        body {
            width: 10cm;
            height: 5cm;
            margin: 2px;
            padding: 0;
        }
        table {
            width: 100%;
            table-layout: fixed;
        }
        .header {
            font-size: 12px;
            font-weight: bold;
            text-align: left;
        }
        .desc {
            font-size: 8px;
            font-weight: normal;
            text-align: left;
            margin-top: 3px;
            margin-bottom: 3px;
        }
        .identitas {
            font-size: 8px;
            text-align: left;
        }
        .identitas div {
            margin-top: 5px;
            display: flex;
            justify-content: space-between;
        }
        .label {
            font-weight: bold;
        }
        .table-peserta {
            width: 100%;
            border-spacing: 0;
            border-collapse: collapse;
        }
        .table-peserta tbody {
            width: 100%;
        }
        .table-peserta tbody tr td {
            font-size: 5px;
        }
        input[type='checkbox'] {
            width:15px;
            height:15px;
        }
        label {
            font-size: 8px;
            margin-left: 2px;
            margin-right: 2px;
            line-height:1;
            margin-top:1px;
        }
        #checkbox-area {
            display: flex;
            justify-content: space-around;
        }
        /* #nama-peserta {
            text-overflow: ellipsis;
            overflow: hidden;
            white-space: nowrap;
        } */
        /* Add your label styling here */
    </style>
</head>
<body>
    <table>
        <tbody>
            <tr>
                <td style="width: 50%">
                    <div class="header">
                        BUKTI REGISTRASI KEDATANGAN
                    </div>
                    <div class="desc">
                        {{\Illuminate\Support\Str::limit($workshop,60)}}
                    </div>
                    <div class="identitas">
                        {{-- <div>
                            <span class="label">Nama</span>
                            <span class="value">YUDO JUNI HARDIKO</span>
                        </div>
                        <div>
                            <span class="label">Instansi</span>
                            <span class="value">Instansi</span>
                        </div> --}}
                        <table id="table-peserta">
                            <tbody>
                                <tr>
                                    <td style="width: 20%; font-size: 8px">No Order</td>
                                    <td style="width: 5%">:</td>
                                    <td style="width: 75%; font-size: 8px">{{$data['transaction']['order_id']}}</td>
                                </tr>
                                <tr>
                                    <td style="width: 20%; font-size: 8px">Nama</td>
                                    <td style="width: 5%">:</td>
                                    <td style="width: 75%; font-size: 8px"><span id="nama-peserta">{{\Illuminate\Support\Str::limit($data['nama'],10)}}</span></td>
                                </tr>
                                <tr>
                                    <td style="width: 20%; font-size: 8px">Instansi</td>
                                    <td style="width: 5%">:</td>
                                    <td style="width: 75%; font-size: 8px">{{\Illuminate\Support\Str::limit($data['nama_rs'],10)}}</td>
                                </tr>
                                <tr>
                                    <td style="width: 20%; font-size: 8px">Kelamin</td>
                                    <td style="width: 5%">:</td>
                                    <td style="width: 75%; font-size: 8px">{{$data['jns_kelamin']}}</td>
                                </tr>
                                {{-- <tr>
                                    <td style="width: 20%; font-size: 8px">Baju</td>
                                    <td style="width: 5%">:</td>
                                    <td style="width: 75%; font-size: 8px">{{$data['baju']}}</td>
                                </tr> --}}
                                <tr>
                                    <td style="width: 20%; font-size: 8px">Paket</td>
                                    <td style="width: 5%">:</td>
                                    <td style="width: 75%; font-size: 8px">{{$data['paket']}}</td>
                                </tr>
                                <tr>
                                   <td colspan="3">
                                        <div id="checkbox-area">
                                             <input type="checkbox" id="sertifikat" name="sertifikat" value="Bike">
                                             <label for="sertifikat">Sertifikat</label>
                                             <input type="checkbox" id="sertifikat" name="sertifikat" value="Bike">
                                             <label for="sertifikat">SOUVENIR</label>
                                             <input type="checkbox" id="sertifikat" name="sertifikat" value="Bike">
                                             <label for="sertifikat">SPPD</label>
                                        </div>
                                    </td> 
                                </tr>
                                {{-- <tr>
                                    <td style="width: 40%">
                                        <input type="checkbox" id="sertifikat" name="sertifikat" value="Bike">
                                        <label for="sertifikat">Sertifikat</label>
                                    </td>
                                    <td style="width: 40%">
                                        <input type="checkbox" id="sertifikat" name="sertifikat" value="Bike">
                                        <label for="sertifikat">SOUVENIR</label>
                                    </td>
                                    <td style="width: 20%">
                                        <input type="checkbox" id="sertifikat" name="sertifikat" value="Bike">
                                        <label for="sertifikat">SPPD</label>
                                    </td>
                                </tr> --}}
                            </tbody>
                        </table>
                    </div>
                </td>
                <td style="width: 50%">
                    <div style="font-size: 10px;font-weight: normal; margin-left: 10px;margin-right: 10px; text-align: center">SCAN BARCODE UNTUK IDENTITAS KEHADIRAN</div>
                    <div style="margin-top: 2px;font-size: 8px;text-align: justify;margin-left: 10px;margin-right: 10px">Mohon diisi dengan benar nama, gelar dan instansi data akan digunakan untuk pembuatan sertifikat</div>
                    <div style="margin-top: 4px; text-align: center">
                        <img src="data:image/png;base64, {!! base64_encode(QrCode::size(60)->generate($url)) !!} ">
                    </div>
                    <div style="margin-top: 15px;font-size: 10px;text-align: center;margin-left: 10px;margin-right: 10px">
                        NO. AMBIL SERTIFIKAT
                    </div>
                    <div style="margin-top: 10px;font-size: 20px;text-align: center;margin-left: 10px;margin-right: 10px; font-weight: bold">
                        {{ $no_urut }}
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>