@extends('layouts.t_template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <button onclick="modalAction('{{ url('tManageKompen/create_ajax') }}')" class="btn btn-sm btn-success mt-1 fa fa-user"> Tambah</button>
        </div>
    </div>
    <div class="card-body">
        @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table-bordered table-striped table-hover table-sm table" id="tabel_kompen">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pemberi Kompen</th>
                    <th>Jenis Tugas Kompen</th>
                    <th>Deskripsi</th>
                    <th>Kuota</th>
                    <th>Jam Kompen</th>
                    <th>Status</th>
                    <th>Waktu Pengerjaan</th>
                    <th>Tag Kompetensi</th>
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
    var dataLevel;
    $(document).ready(function() {
        dataLevel = $('#tabel_kompen').DataTable({
            serverSide: true, // Menggunakan server-side processing
            ajax: {
                "url": "{{ url('tManageKompen/list') }}", // Endpoint untuk mengambil data kategori
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
                    data: "tendik.nama",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "jeniskompen.jenis_kompen",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "deskripsi",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "kuota",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "jam_kompen",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "status",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "deadline",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "bidangkompetensi.tag_bidkom",
                    orderable: true,
                    searchable: true
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