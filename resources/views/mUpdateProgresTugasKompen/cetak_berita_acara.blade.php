<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            margin: 20px;
            line-height: 1.5;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            padding: 4px;
        }

        .header-table {
            margin-bottom: 20px;
        }

        .header-table td {
            vertical-align: top;
        }

        .header-logo {
            text-align: center;
        }

        .header-text {
            text-align: center;
            line-height: 1.2;
        }

        .header-text span {
            display: block;
        }

        .header-title {
            font-weight: bold;
        }

        .line {
            border-bottom: 2px solid black;
            margin: 10px 0 20px 0;
        }

        .document-title {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .content-table {
            margin-top: 20px;
            margin-bottom: 30px;
            width: 100%;
        }

        .content-table td {
            padding: 5px 0;
        }

        .signature-section {
            margin-top: 40px;
        }

        .signature-table {
            width: 100%;
        }

        .signature-table td {
            vertical-align: top;
        }

        .signature {
            text-align: center;
            margin-top: 60px;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <table class="header-table">
        <tr>
            <td width="15%" class="header-logo">
                <img src="{{ public_path('images/logo_polinema.png') }}" width="95" height="95">
            </td>
            <td width="85%" class="header-text">
                <span class="header-title">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI</span>
                <span class="header-title" style="font-size: 14pt;">POLITEKNIK NEGERI MALANG</span>
                <span>Jl. Soekarno-Hatta No. 9 Malang 65141</span>
                <span>Telepon (0341) 404424 Pes. 101-105, 0341-404420, Fax. (0341) 404420</span>
                <span>Laman: www.polinema.ac.id</span>
            </td>
        </tr>
    </table>
    <div class="line"></div>

    <h3 class="document-title">BERITA ACARA KOMPENSASI PRESENSI</h3>

    <table class="content-table">
        <tr>
            <td>Nama Pemberi Tugas</td>
            <td>:</td>
            <td>{{ $nama_pengajar }}</td>
        </tr>
        <tr>
            <td>NIP</td>
            <td>:</td>
            <td>{{ $nip_pengajar }}</td>
        </tr>

        <tr>
            <td colspan="3" style="height: 15px;"></td>
        </tr>
        <tr>
            <td colspan="3">Memberikan rekomendasi kompensasi kepada:</td>
        </tr>
        <tr>
            <td>Nama Mahasiswa</td>
            <td>:</td>
            <td>{{ $nama_mahasiswa }}</td>
        </tr>
        <tr>
            <td>NIM</td>
            <td>:</td>
            <td>{{ $nim }}</td>
        </tr>
        <tr>
            <td>Kelas</td>
            <td>:</td>
            <td>{{ $kelas }}</td>
        </tr>
        <tr>
            <td>Semester</td>
            <td>:</td>
            <td>{{ $semester }}</td>
        </tr>
        <tr>
            <td>Nama Tugas</td>
            <td>:</td>
            <td>{{ $pekerjaan }}</td>
        </tr>
        <tr>
            <td>Jumlah Jam</td>
            <td>:</td>
            <td>{{ $jumlah_jam }}</td>
        </tr>
    </table>

    <div class="signature-section">
        <table class="signature-table">
            <tr>
                <td width="50%">
                    <p>Mengetahui,</p>
                    <p><b>Ka. Program Studi</b></p>
                    <br><br><br>
                    <p><b>(Hendra Pradipta)</b></p>
                    <p><b>NIP: 198305212006041003</b></p>
                </td>
                <td width="50%" style="text-align: right;">
                    <p>Malang, {{ $tanggal }}</p>
                    <p>Yang memberi rekomendasi,</p>
                    <br><br><br>
                    <p><b>{{ $nama_pengajar }}</b></p>
                    <p style="margin-left: 0;"><b>NIP: {{ $nip_pengajar }}</b></p>
                </td>
            </tr>

        </table>
    </div>

    <div style="margin-top: 40px; font-size: 10pt; display: flex; align-items: flex-start;">
        <div style="margin-right: 20px;">
            {!! $qrCode !!}
        </div>

        <div>
            <p><b>NB:</b> Form ini wajib diunggah pada web kompen JTI dan disimpan untuk keperluan bebas tanggungan kompensasi presensi.</p>
        </div>
    </div>
</body>

</html>

