@extends('layouts.m_template')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title ?? 'Daftar Riwayat Kompen' }}</h3>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered table-striped table-hover table-sm" id="table_kompen">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Tugas</th>
                    <th>Pemberi Tugas</th>
                    <th>Jam Kompen</th>
                    <th>Waktu Pengerjaan</th>
                    <th>Aksi</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $kompen)
                <tr>
                    <td>{{ $kompen->no }}</td> <!-- Auto-incrementing ID -->
                    <td>{{ $kompen->nama_tugas }}</td> <!-- Task name -->
                    <td>{{ $kompen->pemberi_kompen }}</td> <!-- Task giver -->
                    <td>{{ $kompen->jam_kompen }}</td> <!-- Compensation hours -->
                    <td>{{ $kompen->waktu_pengerjaan }}</td> <!-- Task duration -->
                    <td>
                        <button type="button" class="btn btn-primary btn-sm elevation-2" data-toggle="modal" data-target="#uploadModal{{ $kompen->no }}">
                            <i class="fas fa-upload"></i>
                        </button>
                    </td>
                    <td>
                        <!-- Status Logic -->
                        @if (!$kompen->file_upload)
                            Belum Unggah
                        @elseif ($kompen->status === 'belum_diterima')
                            Belum Diterima
                        @elseif ($kompen->status === 'diterima')
                            Diterima
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada riwayat kompen.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modals for uploading -->
@foreach ($data as $kompen)
<div class="modal fade" id="uploadModal{{ $kompen->no }}" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('upload_berita_acara', ['id_riwayat' => $kompen->no]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Unggah Berita Acara untuk {{ $kompen->nama_tugas }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="file">Pilih Berkas</label>
                        <input type="file" name="file" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Unggah</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach

@endsection



{{-- @extends('layouts.m_template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title ?? 'Daftar Riwayat Kompen' }}</h3>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered table-striped table-hover table-sm" id="table_kompen">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Tugas</th>
                    <th>Pemberi Tugas</th>
                    <th>Jam Kompen</th>
                    <th>Waktu Pengerjaan</th>
                    <th>Aksi</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $kompen)
                <tr>
                    <td>{{ $kompen->no }}</td>
                    <td>{{ $kompen->nama_tugas }}</td>
                    <td>{{ $kompen->pemberi_kompen }}</td>
                    <td>{{ $kompen->jam_kompen }}</td>
                    <td>{{ $kompen->waktu_pengerjaan }}</td>
                    <td>
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#uploadModal{{ $kompen->no }}">
                            Unggah Berita Acara
                        </button>
                    </td>
                    <td>
                        @if (!$kompen->file_upload)
                            Belum Unggah
                        @elseif ($kompen->status === 'belum_diterima')
                            Belum Diterima
                        @elseif ($kompen->status === 'diterima')
                            Diterima
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada riwayat kompen.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modals for uploading -->
@foreach ($data as $kompen)
<div class="modal fade" id="uploadModal{{ $kompen->no }}" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('upload_berita_acara', ['id_riwayat' => $kompen->no]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Unggah Berita Acara untuk {{ $kompen->nama_tugas }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="file">Pilih Berkas</label>
                        <input type="file" name="file" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Unggah</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach

@endsection --}}
