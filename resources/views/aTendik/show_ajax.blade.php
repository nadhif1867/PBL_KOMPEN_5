@empty($aTendik)
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
            <a href="{{ url('/aTendik') }}" class="btn btn-warning">Kembali</a>
        </div>
    </div>
</div>
@else
<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Detail Tendik</h5>
            <button type="button" class="close" data-dismiss="modal" aria label="Close"><span
                    aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered table-striped table-hover table-sm">
                <tr>
                    <th>ID</th>
                    <td>{{ $aTendik->id_tendik}}</td>
                </tr>
                <tr>
                    <th>Username</th>
                    <td>{{ $aTendik->username}}</td>
                </tr>
                <tr>
                    <th>NIP</th>
                    <td>{{ $aTendik->nip}}</td>
                </tr>
                <tr>
                    <th>No Telepon</th>
                    <td>{{ $aTendik->no_telepon}}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $aTendik->email}}</td>
                </tr>
                <tr>
                    <th>Nama</th>
                    <td>{{ $aTendik->nama}}</td>
                </tr>
                <tr>
                    <th>Avatar</th>
                    <td>{{ $aTendik->avatar}}</td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-warning">Kembali</button>
        </div>
    </div>
</div>
@endempty