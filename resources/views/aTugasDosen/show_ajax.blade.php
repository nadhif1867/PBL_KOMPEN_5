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
            <a href="{{ url('/aTugasDosen') }}" class="btn btn-warning">Kembali</a>
        </div>
    </div>
</div>
@else
<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tugas Dosen</h5>
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
                    <th>Nama Tugas</th>
                    <td>{{ $aTugasDosen->nama_tugas }}</td>
                </tr>
                <tr>
                    <th>Deskripsi</th>
                    <td>{{ $aTugasDosen->deskripsi }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $aTugasDosen->status }}</td>
                </tr>
                <tr>
                    <th>Pemberi Tugas</th>
                    <td>{{ $aTugasDosen->dosen->nama }}</td>
                </tr>
                <tr>
                    <th>Jenis Kompen</th>
                    <td>{{ $aTugasDosen->jeniskompen->jenis_kompen }}</td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-warning">Kembali</button>
        </div>
    </div>
</div>
@endempty