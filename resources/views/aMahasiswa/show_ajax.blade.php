@empty($aMahasiswa)
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
            <a href="{{ url('/aMahasiswa') }}" class="btn btn-warning">Kembali</a>
        </div>
    </div>
</div>
@else
<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Detail Mahasiswa</h5>
            <button type="button" class="close" data-dismiss="modal" aria label="Close"><span
                    aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered table-striped table-hover table-sm">
                <tr>
                    <th>ID</th>
                    <td>{{ $aMahasiswa->id_mahasiswa}}</td>
                </tr>
                <tr>
                    <th>Username</th>
                    <td>{{ $aMahasiswa->username}}</td>
                </tr>
                <tr>
                    <th>NIP</th>
                    <td>{{ $aMahasiswa->nim}}</td>
                </tr>
                <tr>
                    <th>Prodi</th>
                    <td>{{ $aMahasiswa->prodi}}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $aMahasiswa->email}}</td>
                </tr>
                <tr>
                    <th>Tahun Masuk</th>
                    <td>{{ $aMahasiswa->tahun_masuk}}</td>
                </tr>
                <tr>
                    <th>No Telepon</th>
                    <td>{{ $aMahasiswa->no_telepon}}</td>
                </tr>
                <tr>
                    <th>Nama</th>
                    <td>{{ $aMahasiswa->nama}}</td>
                </tr>
                <tr>
                    <th>Avatar</th>
                    <td>{{ $aMahasiswa->avatar}}</td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-warning">Kembali</button>
        </div>
    </div>
</div>
@endempty