<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Otomatis</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            margin: 2cm 2cm 2cm 3cm; /* Margin standar surat resmi */
        }
        .kop-surat {
            text-align: center;
            border-bottom: 3px solid black;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .kop-surat h1 {
            margin: 0;
            font-size: 16pt;
            text-transform: uppercase;
        }
        .kop-surat p {
            margin: 0;
            font-size: 10pt;
        }
        .nomor-tanggal {
            width: 100%;
            margin-bottom: 20px;
        }
        .nomor-tanggal td {
            vertical-align: top;
        }
        .text-right {
            text-align: right;
        }
        .isi-surat {
            text-align: justify;
            margin-bottom: 30px;
        }
        .ttd {
            width: 100%;
            margin-top: 50px;
        }
        .ttd td {
            width: 50%;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="kop-surat">
        <h1>PT. TEKNOLOGI MASA DEPAN</h1>
        <p>Jl. Jend. Sudirman No. 123, Jakarta Pusat | Telp: (021) 1234567</p>
        <p>Email: info@teknologimasadepan.com | Web: www.teknologimasadepan.com</p>
    </div>

    <table class="nomor-tanggal">
        <tr>
            <td>
                Nomor : {{ $nomor_surat }}<br>
                Perihal : Surat Pemberitahuan
            </td>
            <td class="text-right">
                Jakarta, {{ $tanggal }}
            </td>
        </tr>
    </table>

    <p>
        Kepada Yth.,<br>
        <strong>{{ $nama_tujuan }}</strong><br>
        di Tempat
    </p>

    <div class="isi-surat">
        <p>Dengan hormat,</p>
        <p>{{ $isi_surat }}</p>
        <p>Demikian surat ini kami sampaikan. Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.</p>
    </div>

    <table class="ttd">
        <tr>
            <td></td>
            <td>
                Hormat Kami,<br>
                <br>
                <img src="data:image/png;base64, {!! $qrcode !!}" width="90" height="90"><br>
                <br>
                <strong>Direktur Utama</strong>
            </td>
        </tr>
    </table>
</body>
</html>