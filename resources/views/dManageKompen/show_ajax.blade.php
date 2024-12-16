@empty($aTugasDosen)
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
            <a href="{{ url('/dManageKompen') }}" class="btn btn-warning">Kembali</a>
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
                    <td>{{ $aTugasDosen->id_tugas_dosen}}</td>
                </tr>
                <tr>
                    <th>Jenis Kompen</th>
                    <td>{{ $aTugasDosen->dosen->nama }}</td>
                </tr>
                <tr>
                    <th>Deskripsi</th>
                    <td>{{ $aTugasDosen->deskripsi}}</td>
                </tr>
                <tr>
                    <th>Kuota</th>
                    <td>{{ $aTugasDosen->kuota}}</td>
                </tr>
                <tr>
                    <th>Jam Kompen</th>
                    <td>{{ $aTugasDosen->jam_kompen}}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $aTugasDosen->status}}</td>
                </tr>
                <tr>
                    <th>Tanggal Mulai</th>
                    <td>{{ $aTugasDosen->tanggal_mulai}}</td>
                </tr>
                <tr>
                    <th>Tanggal Selesai</th>
                    <td>{{ $aTugasDosen->tanggal_selesai}}</td>
                </tr>
                <tr>
                    <th>Bidang Kompetensi</th>
                    <td>{{ $aTugasDosen->bidangkompetensi->tag_bidkom}}</td>
                </tr>
                <tr>
                    <th>Jenis Tugas</th>
                    <td>{{ $aTugasDosen->jeniskompen->jenis_kompen}}</td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-warning">Kembali</button>
        </div>
    </div>
</div>
@endempty