@empty($aTugasTendik)
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
            <a href="{{ url('/tManageKompen') }}" class="btn btn-warning">Kembali</a>
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
                    <td>{{ $aTugasTendik->id_tugas_tendik}}</td>
                </tr>
                <tr>
                    <th>Jenis Kompen</th>
                    <td>{{ $aTugasTendik->tendik->nama }}</td>
                </tr>
                <tr>
                    <th>Deskripsi</th>
                    <td>{{ $aTugasTendik->deskripsi}}</td>
                </tr>
                <tr>
                    <th>Kuota</th>
                    <td>{{ $aTugasTendik->kuota}}</td>
                </tr>
                <tr>
                    <th>Jam Kompen</th>
                    <td>{{ $aTugasTendik->jam_kompen}}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $aTugasTendik->status}}</td>
                </tr>
                <tr>
                    <th>Tanggal Mulai</th>
                    <td>{{ $aTugasTendik->tanggal_mulai}}</td>
                </tr>
                <tr>
                    <th>Tanggal Selesai</th>
                    <td>{{ $aTugasTendik->tanggal_selesai}}</td>
                </tr>
                <tr>
                    <th>Bidang Kompetensi</th>
                    <td>{{ $aTugasTendik->bidangkompetensi->tag_bidkom}}</td>
                </tr>
                <tr>
                    <th>Jenis Tugas</th>
                    <td>{{ $aTugasTendik->jeniskompen->jenis_kompen}}</td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-warning">Kembali</button>
        </div>
    </div>
</div>
@endempty