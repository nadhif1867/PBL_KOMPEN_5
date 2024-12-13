@extends('layouts.a_template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <!-- <div class="card-tools">
            <button onclick="modalAction('{{ url('aDosen/create_ajax') }}')" class="btn btn-sm btn-success mt-1 fa fa-user"> Tambah</button>
        </div> -->
    </div>
    <div class="card-body">
        @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <table class="table-bordered table-striped table-hover table-sm table" id="tabel_dosen">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Tugas</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Pemberi Tugas</th>
                    <th>Jenis Kompen</th>  
                                   
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
    var dataDosen;
    $(document).ready(function() {
        dataDosen = $('#tabel_dosen').DataTable({
            serverSide: true, // Menggunakan server-side processing
            ajax: {
                "url": "{{ url('aTugasAdmin/list') }}", // Endpoint untuk mengambil data kategori
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
                    data: "nama_tugas",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "deskripsi",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "status",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "tanggal_mulai",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "tanggal_selesai",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "admin.nama",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "jeniskompen.jenis_kompen",
                    orderable: false,
                    searchable: false
                },         
            ]
        });

        // Reload tabel saat filter kategori diubah
        $('#kode_level').on('change', function() {
            dataLevel.ajax.reload(); // Memuat ulang tabel berdasarkan filter yang dipilih
        });
    });
</script>
@endpush