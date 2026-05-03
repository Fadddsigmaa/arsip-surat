<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Otomatis</title>
    <style>
        /* Pengaturan umum PDF */
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12px;
            line-height: 1.5;
            margin: 1cm 1.5cm 1cm 2.5cm; 
        }

        /* Pengaturan khusus Kop Surat */
        .kop-surat {
            width: 100%;
            margin-bottom: 2px;
        }
        .kop-surat table {
            width: 100%;
            border-collapse: collapse;
            border: none;
        }
        .kop-surat td {
            border: none;
            padding: 0;
        }
        
        /* --------------------------------- */
        /* CSS KHUSUS KOP GMNI               */
        /* --------------------------------- */
        .logo-container {
            width: 15%;
            text-align: center;
            vertical-align: middle;
        }
        .logo-container img {
            max-width: 90px;
            height: auto;
        }
        .text-container {
            width: 85%;
            text-align: center;
            vertical-align: middle;
        }
        .title-red {
            color: red;
            font-weight: bold;
            font-size: 16px; 
            line-height: 1.2;
            text-transform: uppercase;
        }
        .address-text {
            color: black;
            font-weight: bold;
            font-size: 11px; 
            margin-top: 3px;
            line-height: 1.3;
        }

        /* --------------------------------- */
        /* CSS KHUSUS KOP HMTI UIS           */
        /* --------------------------------- */
        .hmti-logo-kiri, .hmti-logo-kanan {
            width: 15%;
            text-align: center;
            vertical-align: middle;
        }
        .hmti-logo-kiri img, .hmti-logo-kanan img {
            max-width: 85px;
            height: auto;
        }
        .hmti-teks-tengah {
            width: 70%;
            text-align: center;
            vertical-align: middle;
        }
        .hmti-title-1 {
            color: #006600; /* Warna Hijau */
            font-size: 16px;
            font-weight: bold;
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.2;
        }
        .hmti-title-2 {
            color: black;
            font-size: 17px;
            font-weight: bold;
            font-family: 'Times New Roman', Times, serif;
            letter-spacing: 1px;
            line-height: 1.2;
            margin-top: 2px;
        }
        .hmti-title-3 {
            color: red;
            font-size: 17px;
            font-weight: bold;
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.2;
            margin-top: 2px;
        }
        .hmti-address {
            color: black;
            font-size: 11px;
            line-height: 1.3;
            margin-top: 4px;
        }

        /* Garis tebal ganda di bawah kop surat */
        .garis-tebal {
            border-top: 3px solid black;
            margin-top: 5px;
            margin-bottom: 1px;
        }
        .garis-tipis {
            border-top: 1px solid black;
            margin-top: 1px;
            margin-bottom: 15px;
        }

        /* Pengaturan Isi Surat */
        .nomor-tanggal {
            width: 100%;
            margin-bottom: 20px;
        }
        .nomor-tanggal td {
            vertical-align: top;
            border: none;
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
            vertical-align: top;
            border: none;
        }
    </style>
</head>
<body>

    <div class="kop-surat">
        {{-- Logika Switch: Memilih Kop Surat Berdasarkan Input Form --}}
        @switch($kop_surat ?? 'hmti')
            
            {{-- PILIHAN 1: KOP GMNI --}}
            @case('gmni')
                <table>
                    <tr>
                        <td class="logo-container">
                            @php
                                $path = public_path('images/logo-gmni.png');
                                $base64 = '';
                                if(file_exists($path)){
                                    $type = pathinfo($path, PATHINFO_EXTENSION);
                                    $data = file_get_contents($path);
                                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                                }
                            @endphp
                            
                            @if($base64)
                                <img src="{{ $base64 }}" alt="Logo GMNI">
                            @else
                                <span style="font-size: 8px; color: gray;">Logo<br>Not Found</span>
                            @endif
                        </td>
                        <td class="text-container">
                            <div class="title-red">DEWAN PIMPINAN CABANG</div>
                            <div class="title-red">GERAKAN MAHASISWA NASIONAL INDONESIA</div>
                            <div class="title-red">(GMNI)</div>
                            <div class="title-red">KOTA BATAM</div>
                            <div class="address-text">
                                Sekretariat Sementara : Jl.Suprapto<br>
                                Perum. Muka Kuning Indah 2 Blok P No. 5 Batu Aji, Batam<br>
                                HP 0895-6366-40415 / Email : dpcgmnibatam2021@gmail.com
                            </div>
                        </td>
                    </tr>
                </table>
                @break

            {{-- PILIHAN 2: KOP HMTI UIS (DEFAULT) --}}
            @case('hmti')
            @default
                <table>
                    <tr>
                        {{-- Kolom 1: Logo Kiri (UIS) --}}
                        <td class="hmti-logo-kiri">
                            @php
                                $pathUis = public_path('images/logo-uis.png');
                                $base64Uis = '';
                                if(file_exists($pathUis)){
                                    $type = pathinfo($pathUis, PATHINFO_EXTENSION);
                                    $data = file_get_contents($pathUis);
                                    $base64Uis = 'data:image/' . $type . ';base64,' . base64_encode($data);
                                }
                            @endphp
                            @if($base64Uis)
                                <img src="{{ $base64Uis }}" alt="Logo UIS">
                            @else
                                <span style="font-size: 8px; color: gray;">Logo UIS<br>Not Found</span>
                            @endif
                        </td>

                        {{-- Kolom 2: Teks Tengah --}}
                        <td class="hmti-teks-tengah">
                            <div class="hmti-title-1">UNIVERSITAS IBNU SINA (UIS)</div>
                            <div class="hmti-title-2">FAKULTAS SAINS & TEKNOLOGI</div>
                            <div class="hmti-title-3">HIMPUNAN MAHASISWA TEKNIK INFORMATIKA (HMTI)</div>
                            <div class="hmti-address">
                                Sekretariat: UIS Ged B lt. 2 Jl. Teuku Umar Lubuk Baja Telp: 081288323008<br>
                                Email: <span style="color: blue; text-decoration: underline;">hmti@uis.ac.id</span> , Kota Batam – Indonesia 2943
                            </div>
                        </td>

                        {{-- Kolom 3: Logo Kanan (HMTI) --}}
                        <td class="hmti-logo-kanan">
                            @php
                                $pathHmti = public_path('images/logo-hmti.png');
                                $base64Hmti = '';
                                if(file_exists($pathHmti)){
                                    $type = pathinfo($pathHmti, PATHINFO_EXTENSION);
                                    $data = file_get_contents($pathHmti);
                                    $base64Hmti = 'data:image/' . $type . ';base64,' . base64_encode($data);
                                }
                            @endphp
                            @if($base64Hmti)
                                <img src="{{ $base64Hmti }}" alt="Logo HMTI">
                            @else
                                <span style="font-size: 8px; color: gray;">Logo HMTI<br>Not Found</span>
                            @endif
                        </td>
                    </tr>
                </table>
                @break

        @endswitch
    </div>
    
    <hr class="garis-tebal">
    <hr class="garis-tipis">

    <table class="nomor-tanggal">
        <tr>
            <td>
                Nomor : {{ $nomor_surat ?? '...' }}<br>
                Perihal : Surat Pemberitahuan
            </td>
            <td class="text-right">
                Batam, {{ $tanggal ?? date('d F Y') }}
            </td>
        </tr>
    </table>

    <p>
        Kepada Yth.,<br>
        <strong>{{ $nama_tujuan ?? 'Bapak/Ibu' }}</strong><br>
        di Tempat
    </p>

    <div class="isi-surat">
        <p>Dengan hormat,</p>
        <p>{{ $isi_surat ?? 'Berikut adalah isi surat...' }}</p>
        <p>Demikian surat ini kami sampaikan. Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.</p>
    </div>

    <table class="ttd">
        <tr>
            <td></td>
            <td>
                Hormat Kami,<br>
                <br>
                @if(isset($qrcode) && $qrcode)
                    <img src="data:image/png;base64, {!! $qrcode !!}" width="80" height="80"><br>
                @else
                    <br><br><br>
                @endif
                <br>
                <strong>Ketua / Direktur</strong>
            </td>
        </tr>
    </table>
    
</body>
</html>