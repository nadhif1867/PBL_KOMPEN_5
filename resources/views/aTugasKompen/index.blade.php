@extends('layouts.a_template')

@section('content')
<div class="container">
    <h2>Manage Kompen</h2>

    <!-- Button untuk membuat tugas kompen baru -->
    <!-- <a href="{{ route('tugas_kompen.create') }}" class="btn btn-primary mb-3">Create</a> -->

    <!-- Table untuk menampilkan daftar tugas kompen -->
    <table id="tugas-kompen-table" class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
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
        <tbody>
            <!-- Data akan dimuat menggunakan DataTables -->
        </tbody>
    </table>
</div>

<!-- Modal untuk menampilkan detail tugas kompen -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Tugas Kompen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Pemberi Kompen:</strong> <span id="modal-pemberi-kompen"></span></p>
                <p><strong>Jenis Tugas Kompen:</strong> <span id="modal-jenis-tugas"></span></p>
                <p><strong>Deskripsi:</strong> <span id="modal-deskripsi"></span></p>
                <p><strong>Kuota:</strong> <span id="modal-kuota"></span></p>
                <p><strong>Jam Kompen:</strong> <span id="modal-jam-kompen"></span></p>
                <p><strong>Status:</strong> <span id="modal-status"></span></p>
                <p><strong>Waktu Pengerjaan:</strong> <span id="modal-waktu-pengerjaan"></span></p>
                <p><strong>Tag Kompetensi:</strong> <span id="modal-tag-kompetensi"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#tugas-kompen-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('aTugasKompen/list') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'pemberi_kompen',
                    name: 'pemberi_kompen'
                },
                {
                    data: 'jenis_tugas',
                    name: 'jenis_tugas'
                },
                {
                    data: 'deskripsi',
                    name: 'deskripsi'
                },
                {
                    data: 'kuota',
                    name: 'kuota'
                },
                {
                    data: 'jam_kompen',
                    name: 'jam_kompen'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'waktu_pengerjaan',
                    name: 'waktu_pengerjaan'
                },
                {
                    data: 'tag_bidkom',
                    name: 'tag_bidkom'
                },
                {
                    data: 'id',
                    render: function(data, type, row) {
                        return `
                            <button class="btn btn-info btn-sm" onclick="showDetail(${data})">Detail</button>
                            <button class="btn btn-warning btn-sm" onclick="editTugas(${data})">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteTugas(${data})">Hapus</button>
                        `;
                    },
                    orderable: false
                }
            ]
        });
    });

    // Function to show task details in modal
    function showDetail(id) {
        $.ajax({
            url: `/aTugasKompen/${id}/show_ajax`,
            method: 'GET',
            success: function(response) {
                $('#modal-pemberi-kompen').text(response.pemberi_kompen);
                $('#modal-jenis-tugas').text(response.jenis_tugas);
                $('#modal-deskripsi').text(response.deskripsi);
                $('#modal-kuota').text(response.kuota);
                $('#modal-jam-kompen').text(response.jam_kompen);
                $('#modal-status').text(response.status);
                $('#modal-waktu-pengerjaan').text(response.waktu_pengerjaan);
                $('#modal-tag-kompetensi').text(response.tag_bidkom);
                $('#detailModal').modal('show');
            },
            error: function() {
                alert('Error loading task details.');
            }
        });
    }

    // Placeholder functions for Edit and Delete buttons
    function editTugas(id) {
        alert('Edit task with ID ' + id);
    }

    function deleteTugas(id) {
        alert('Delete task with ID ' + id);
    }
</script>
@endsection