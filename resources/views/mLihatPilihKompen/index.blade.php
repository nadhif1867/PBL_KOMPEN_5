@extends('layouts.m_template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
    </div>
    <div class="card-body">
        @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered table-striped table-hover table-sm" id="table_user">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Pemberi Tugas</th>
                    <th>Jenis Tugas</th>
                    <th>Deskripsi</th>
                    <th>Kuota</th>
                    <th>Jam Kompen</th>
                    <th>Waktu Pengerjaan</th> <!-- Kolom Waktu Pengerjaan -->
                    <th>Aksi</th>
                    <th>Status Permintaan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tugasKompen as $key => $tugas)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $tugas->pemberi_tugas }}</td>
                    <td>{{ $tugas->jenis_tugas }}</td>
                    <td>{{ $tugas->deskripsi }}</td>
                    <td>{{ $tugas->kuota }}</td>
                    <td>{{ $tugas->jam_kompen }}</td>
                    <td>{{ $tugas->waktu_pengerjaan }} </td> <!-- Menampilkan waktu pengerjaan -->

                    <!-- Tombol Apply hanya muncul jika status belum apply -->
                    <td>
                        @if ($tugas->status_permintaan === null)
                        <a href="{{ route('tugas-kompen.apply', ['id' => $tugas->id_tugas_kompen]) }}" class="btn btn-primary btn-sm">Apply</a>
                        @elseif ($tugas->status_permintaan === 'request')
                        <button class="btn btn-secondary btn-sm" disabled>Berhasil Apply</button>
                        @elseif ($tugas->status_permintaan === 'diterima')
                        <button class="btn btn-success btn-sm" disabled>Diterima</button>
                        @elseif ($tugas->status_permintaan === 'ditolak')
                        <button class="btn btn-danger btn-sm" disabled>Ditolak</button>
                        @endif
                    </td>

                    <!-- Menampilkan status permintaan -->
                    <td>
                        @switch($tugas->status_permintaan)
                        @case('request')
                        <span class="badge bg-warning">Request</span>
                        @break
                        @case('diterima')
                        <span class="badge bg-success">Diterima</span>
                        @break
                        @case('ditolak')
                        <span class="badge bg-danger">Ditolak</span>
                        {{-- @break --}}
                        {{-- @default
                                <span class="badge bg-secondary">Belum Diajukan</span> --}}
                        @endswitch
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada tugas tersedia</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
