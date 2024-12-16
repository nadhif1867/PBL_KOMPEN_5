@empty($aTugasAdmin)
<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
            <button type="button" class="close" data-dismiss="modal" aria label="Close"><span
                    aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger">
                <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                Data yang anda cari tidak ditemukan
            </div>
            <a href="{{ url('/aManageKompen') }}" class="btn btn-warning">Kembali</a>
        </div>
    </div>
</div>
@else
<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Manage Kompen</h5>
            <button type="button" class="close" data-dismiss="modal" aria label="Close"><span
                    aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered table-striped table-hover table-sm">
                <tr>
                    <th>ID</th>
                    <td>{{ $aTugasAdmin->id_tugas_admin}}</td>
                </tr>
                <tr>
                    <th>Jenis Kompen</th>
                    <td>{{ $aTugasAdmin->admin->nama }}</td>
                </tr>
                <tr>
                    <th>Deskripsi</th>
                    <td>{{ $aTugasAdmin->deskripsi}}</td>
                </tr>
                <tr>
                    <th>Kuota</th>
                    <td>{{ $aTugasAdmin->kuota}}</td>
                </tr>
                <tr>
                    <th>Jam Kompen</th>
                    <td>{{ $aTugasAdmin->jam_kompen}}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $aTugasAdmin->status}}</td>
                </tr>
                <tr>
                    <th>Tanggal Mulai</th>
                    <td>{{ $aTugasAdmin->tanggal_mulai}}</td>
                </tr>
                <tr>
                    <th>Tanggal Selesai</th>
                    <td>{{ $aTugasAdmin->tanggal_selesai}}</td>
                </tr>
                <tr>
                    <th>Bidang Kompetensi</th>
                    <td>{{ $aTugasAdmin->bidangkompetensi->tag_bidkom}}</td>
                </tr>
                <tr>
                    <th>Jenis Tugas</th>
                    <td>{{ $aTugasAdmin->jeniskompen->jenis_kompen}}</td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-warning">Kembali</button>
        </div>
    </div>
</div>
@endempty