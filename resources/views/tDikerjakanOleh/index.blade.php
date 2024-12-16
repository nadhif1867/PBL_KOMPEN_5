@extends('layouts.t_template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
    </div>
    <div class="card-body">
        <!-- Container untuk menampilkan pesan sukses/error -->
        <div id="alert-container">
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
        </div>

        <!-- Tabel data -->
        <table class="table-bordered table-striped table-hover table-sm table" id="tabel_kompen">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Mahasiswa</th>
                    <th>Nama Tugas</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        dataLevel = $('#tabel_kompen').DataTable({
            serverSide: true,
            ajax: {
                url: "{{ url('tDikerjakanOleh/list') }}", // URL endpoint untuk data
                type: "POST",
                data: function(d) {
                    d.kode_level = $('#kode_level').val(); // Jika ada filter tambahan
                }
            },
            columns: [{
                    data: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "mahasiswa.nama",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "tugastendik.nama_tugas",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "tugastendik.deskripsi",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "aksi",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                }
            ]
        });

        // Reload tabel saat filter kategori diubah
        $('#kode_level').on('change', function() {
            dataLevel.ajax.reload();
        });
    });


    // Fungsi untuk memperbarui status
    function updateStatus(id, status) {
        if (confirm('Apakah Anda yakin ingin mengubah status menjadi ' + status + '?')) {
            $.ajax({
                url: "{{ url('tDikerjakanOleh/updateStatus') }}",
                type: "POST",
                data: {
                    id: id,
                    status: status,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    // Kosongkan container alert
                    $('#alert-container').empty();

                    if (response.success) {
                        // Tampilkan alert sukses
                        $('#alert-container').html(`
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                ${response.message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `);
                    } else {
                        // Tampilkan alert error
                        $('#alert-container').html(`
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                ${response.message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `);
                    }

                    // Reload tabel data
                    $('#tabel_kompen').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    // Tampilkan alert error jika permintaan gagal
                    $('#alert-container').html(`
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Terjadi kesalahan pada server. Silakan coba lagi.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `);
                }
            });
        }
    }
    // Hapus alert 
    setTimeout(() => {
        const alertElement = document.querySelector('.alert');
        if (alertElement) {
            alertElement.remove(); // Hapus elemen alert
        }
    }, 3000);
</script>
@endpush