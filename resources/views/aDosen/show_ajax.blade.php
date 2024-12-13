@empty($aDosen)
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
            <a href="{{ url('/aDosen') }}" class="btn btn-warning">Kembali</a>
        </div>
    </div>
</div>
@else
<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Detail Dosen</h5>
            <button type="button" class="close" data-dismiss="modal" aria label="Close"><span
                    aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered table-striped table-hover table-sm">
                <tr>
                    <th>ID</th>
                    <td>{{ $aDosen->id_dosen}}</td>
                </tr>
                <tr>
                    <th>Username</th>
                    <td>{{ $aDosen->username}}</td>
                </tr>
                <tr>
                    <th>NIP</th>
                    <td>{{ $aDosen->nip}}</td>
                </tr>
                <tr>
                    <th>No Telepon</th>
                    <td>{{ $aDosen->no_telepon}}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $aDosen->email}}</td>
                </tr>
                <tr>
                    <th>Nama</th>
                    <td>{{ $aDosen->nama}}</td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-warning">Kembali</button>
        </div>
    </div>
</div>
@endempty