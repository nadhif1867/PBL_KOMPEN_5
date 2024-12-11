@empty($aManageMahasiswaKompen)
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
            <a href="{{ url('/aManageMahasiswaKompen') }}" class="btn btn-warning">Kembali</a>
        </div>
    </div>
</div>
@else
<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Detail Alpha Mahasiswa</h5>
            <button type="button" class="close" data-dismiss="modal" aria label="Close"><span
                    aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered table-striped table-hover table-sm">
                <tr>
                    <th>ID</th>
                    <td>{{ $aManageMahasiswaKompen->id_alpha}}</td>
                </tr>
                <tr>
                    <th>Nama Mahasiswa</th>
                    <td>{{ $aManageMahasiswaKompen->mahasiswa->nama }}</td>
                </tr>
                <tr>
                    <th>NIM</th>
                    <td>{{ $aManageMahasiswaKompen->mahasiswa->nim }} Jam</td>
                </tr>
                <tr>
                    <th>Jumlah Jam Kompen</th>
                    <td>{{ $aManageMahasiswaKompen->jumlah_alpha }} Jam</td>
                </tr>
                <tr>
                    <th>Jumlah Jam Kompen Terbayar</th>
                    <td>{{ $aManageMahasiswaKompen->kompen_dibayar }}</td>
                </tr>
                <tr>
                    <th>Prodi</th>
                    <td>{{ $aManageMahasiswaKompen->mahasiswa->prodi }}</td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-warning">Kembali</button>
        </div>
    </div>
</div>
@endempty