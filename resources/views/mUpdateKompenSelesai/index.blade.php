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
                    <td>{{ $kompen->no }}</td>
                    <td>{{ $kompen->nama_tugas }}</td>
                    <td>{{ $kompen->pemberi_kompen }}</td>
                    <td>{{ $kompen->jam_kompen }}</td>
                    <td>{{ $kompen->waktu_pengerjaan }}</td>
                    <td>
                        <button type="button" class="btn btn-primary btn-sm elevation-2"
                            data-toggle="modal"
                            data-target="#uploadModal{{ $kompen->id_tugas_kompen }}">
                            <i class="fas fa-upload"></i>
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

                <!-- Modal Unggah -->
                <div class="modal fade" id="uploadModal{{ $kompen->id_tugas_kompen }}" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel{{ $kompen->id_tugas_kompen }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <form action="{{ route('upload_berita_acara', ['id_riwayat' => $kompen->id_tugas_kompen]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="uploadModalLabel{{ $kompen->id_tugas_kompen }}">Unggah Berita Acara</h5>
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
                @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada riwayat kompen.</td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>
</div>

@foreach ($data as $kompen)
<div class="modal fade" id="uploadModal{{ $kompen->id_tugas_kompen }}" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('upload_berita_acara', ['id_riwayat' => $kompen->id_tugas_kompen]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Unggah Berita Acara untuk tugas {{ $kompen->nama_tugas }}</h5>
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
