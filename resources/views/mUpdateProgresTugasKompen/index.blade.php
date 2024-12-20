{{-- @extends('layouts.m_template')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


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
                        <th>Nama Tugas</th>
                        <th>Jam Kompen</th>
                        <th>Waktu Pengerjaan</th>
                        <th>Progres</th>
                        <th>Aksi</th>
                        <th>Surat Berita Acara</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($progressData as $key => $progress)
                        <tr data-id="{{ $progress->id_tugas_kompen }}">
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $progress->pemberi_kompen }}</td>
                            <td>{{ $progress->nama_tugas }}</td>
                            <td>{{ $progress->jam_kompen }}</td>
                            <td>{{ $progress->waktu_pengerjaan }}</td>
                            <td>
                                <span class="editable-progress" data-id="{{ $progress->id_tugas_kompen }}">
                                    {{ $progress->progres ?? '-' }}
                                </span>
                            </td>

                            <td>
                                <button class="btn btn-warning btn-sm edit-progress-btn"
                                    data-id="{{ $progress->id_tugas_kompen }}">
                                    Update Progress
                                </button>
                            </td>
                            <td>
                                <a href="{{ route('cetak.berita.acara', ['id' => $progress->id_tugas_kompen]) }}"
                                    class="btn btn-primary btn-sm">
                                     Cetak
                                 </a>
                            </td>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"></div>
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        $(document).on('click', '.edit-progress-btn', function() {
            const taskId = $(this).data('id');

            $.ajax({
                url: `/fetch-tugas-data/${taskId}`,
                type: 'GET',
                success: function(data) {
                    $('#myModal').html(data).modal('show');
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to fetch task data!',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });


        $(document).on('click', '#save-progress-btn', function() {
            const taskId = $('#task-id').val();
            const progress = $('#progress-input').val();

            $.ajax({
                url: `/update-progress/${taskId}`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    progress: progress
                },
                success: function(response) {
                    $('#myModal').modal('hide');

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Update Progres Tugas Kompen',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        $(`tr[data-id="${taskId}"] .editable-progress`).text(
                            progress);
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Progres Tidak Boleh Kosong',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    });
</script> --}}

@extends('layouts.m_template')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                    <th>Nama Tugas</th>
                    <th>Jam Kompen</th>
                    <th>Waktu Pengerjaan</th>
                    <th>Progres</th>
                    <th>Aksi</th>
                    <th>Surat Berita Acara</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($progressData as $key => $progress)
                <tr data-id="{{ $progress->id_tugas_kompen }}">
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $progress->pemberi_kompen }}</td>
                    <td>{{ $progress->nama_tugas }}</td>
                    <td>{{ $progress->jam_kompen }}</td>
                    <td>{{ $progress->waktu_pengerjaan }}</td>
                    <td>
                        <span class="editable-progress" data-id="{{ $progress->id_tugas_kompen }}">
                            {{ $progress->progres ?? '-' }}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-warning btn-sm edit-progress-btn"
                            data-id="{{ $progress->id_tugas_kompen }}">
                            Update Progress
                        </button>
                    </td>
                    <td>
                        <a href="{{ route('cetak.berita.acara', ['id' => $progress->id_tugas_kompen]) }}"
                            class="btn btn-primary btn-sm">
                             Cetak
                         </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"></div>
@endsection

<script>
    $(document).ready(function() {
        $(document).on('click', '.edit-progress-btn', function() {
            const taskId = $(this).data('id');

            $.ajax({
                url: `/fetch-tugas-data/${taskId}`,
                type: 'GET',
                success: function(data) {
                    $('#myModal').html(data).modal('show');
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to fetch task data!',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        $(document).on('click', '#save-progress-btn', function() {
            const taskId = $('#task-id').val();
            const progress = $('#progress-input').val();

            // Validation for empty progress input
            if (!progress) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Progres tidak boleh kosong',
                    confirmButtonText: 'OK'
                });
                return;
            }

            // Validation for progress range
            if (isNaN(progress) || progress < 0 || progress > 100) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Nilai progres tidak valid, harus antara 0-100%',
                    confirmButtonText: 'OK'
                });
                return;
            }

            $.ajax({
                url: `/update-progress/${taskId}`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    progress: progress
                },
                success: function(response) {
                    $('#myModal').modal('hide');

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Update Progres Tugas Kompen',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        // Update progress value in table
                        $(`tr[data-id="${taskId}"] .editable-progress`).text(progress);
                    });
                },
                error: function(xhr, status, error) {
                    const response = xhr.responseJSON;

                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: response.message || 'Update progres gagal.',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    });
</script>

