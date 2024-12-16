<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Kompen</title>
    <style>
        body { font-family: "Times New Roman", Times, serif; margin: 20px; line-height: 1.5; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        h3, p { text-align: center; margin-top: 10px; margin-bottom: 5px; }
        .header { display: flex; align-items: center; margin-bottom: 20px; }
        .header img { width: 95px; height: 95px; margin-right: 15px; }
        .header .header-text { text-align: center; flex: 1; }
        .line { border-bottom: 2px solid black; margin: 10px 0 20px; }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        {{-- <img src="{{ public_path('images/logo_polinema.png') }}" alt=""> --}}
        <div class="header-text">
            <h3>KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI</h3>
            <h3 style="font-weight: bold;">POLITEKNIK NEGERI MALANG</h3>
            <p>Jl. Soekarno-Hatta No. 9 Malang 65141</p>
            <p>Telepon (0341) 404424 Pes. 101-105, 0341-404420, Fax. (0341) 404420</p>
            <p>Laman: www.polinema.ac.id</p>
        </div>
    </div>
    <div class="line"></div>

    <!-- Judul Laporan -->
    <h3>LAPORAN KOMPENSASI SEMESTER {{ $periode }}</h3>
    <p>Tanggal Cetak: {{ $tanggalCetak }}</p>

  
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Tugas</th>
                <th>Pemberi Tugas</th>
                <th>Jumlah Jam</th>
                <th>Waktu Pengerjaan</th>
                <th>NIM</th>
                <th>Nama Mahasiswa</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($dataPresensi as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->nama_tugas ?? '-' }}</td>
                <td>{{ $item->pemberi_tugas ?? '-' }}</td>
                <td>{{ $item->jumlah_jam ?? '-' }} Jam</td>
                <td>
                    {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d-m-Y') }} -
                    {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d-m-Y') }}
                </td>
                <td>{{ $item->nim ?? '-' }}</td>
                <td>{{ $item->nama_mahasiswa ?? '-' }}</td>
                <td>{{ $item->status ?? 'Belum Diterima' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8">Data tidak ditemukan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
