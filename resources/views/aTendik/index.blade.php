@extends('layouts.a_template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <button onclick="modalAction('{{ url('aTendik/create_ajax') }}')" class="btn btn-sm btn-success mt-1 fa fa-user"> Tambah</button>
        </div>
    </div>
    <div class="card-body">
        @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <table class="table-bordered table-striped table-hover table-sm table" id="tabel_tendik">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Lengkap</th>
                    <th>NIM</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('css')
@endpush

@push('js')
<script>
    function modalAction(url = '') {
        $('#myModal').load(url, function() {
            $('#myModal').modal('show');
        })
    }
    var dataTendik;
    $(document).ready(function() {
        dataTendik = $('#tabel_tendik').DataTable({
            serverSide: true, // Menggunakan server-side processing
            ajax: {
                "url": "{{ url('aTendik/list') }}", // Endpoint untuk mengambil data kategori
                "dataType": "json",
                "type": "POST",
                "data": function(d) {
                    d.kode_level = $('#kode_level').val(); // Mengirim data filter kategori_kode
                }
            },
            columns: [{
                    data: "DT_RowIndex", // Menampilkan nomor urut dari Laravel DataTables addIndexColumn()
                    className: "text-center",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "nama",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "nip",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "username",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "email",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "aksi", // Kolom aksi (Edit, Hapus)
                    className: "text-center",
                    orderable: false,
                    searchable: false
                }
            ]
        });

        // Reload tabel saat filter kategori diubah
        $('#kode_level').on('change', function() {
            dataLevel.ajax.reload(); // Memuat ulang tabel berdasarkan filter yang dipilih
        });
    });
</script>
@endpush