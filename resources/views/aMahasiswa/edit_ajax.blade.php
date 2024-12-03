@empty($aMahasiswa)
<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
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
<form action="{{ url('/aMahasiswa/' . $aMahasiswa->id_mahasiswa . '/update_ajax') }}" method="POST" id="form-edit">
    @csrf
    @method('PUT')
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Mahasiswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_level" id="id_level" value="4">

                <div class="form-group">
                    <label>Username</label>
                    <input value="{{ $aMahasiswa->username }}" type="text" name="username" id="username" class="form-control" required>
                    <small id="error-username" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input value="" type="password" name="password" id="password" class="form-control" required>
                    <small id="error-password" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>NIM</label>
                    <input value="{{ $aMahasiswa->nim }}" type="text" name="nim" id="nim" class="form-control" required>
                    <small id="error-nim" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Prodi</label>
                    <input value="{{ $aMahasiswa->prodi }}" type="text" name="prodi" id="prodi" class="form-control" required>
                    <small id="error-prodi" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input value="{{ $aMahasiswa->email }}" type="text" name="email" id="email" class="form-control" required>
                    <small id="error-email" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Tahun Masuk</label>
                    <input value="{{ $aMahasiswa->tahun_masuk }}" type="text" name="tahun_masuk" id="tahun_masuk" class="form-control" required>
                    <small id="error-tahun_masuk" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>No Telepon</label>
                    <input value="{{ $aMahasiswa->no_telepon }}" type="text" name="no_telepon" id="no_telepon" class="form-control" required>
                    <small id="error-no_telepon" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Nama Mahasiswa</label>
                    <input value="{{ $aMahasiswa->nama }}" type="text" name="nama" id="nama" class="form-control" required>
                    <small id="error-nama" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Avatar</label>
                    <input value="" type="file" name="avatar" id="avatar" class="form-control" required>
                    <small id="error-avatar" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready(function() {
        $("#form-edit").validate({
            rules: {
                username: {
                    required: true,
                    minlength: 5,
                    maxlength: 30
                },
                password: {
                    required: false,
                    minlength: 5,
                    maxlength: 20
                },
                nim: {
                    required: true,
                    minlength: 3,
                    maxlength: 20
                },
                prodi: {
                    required: true,
                    minlength: 5,
                },
                email: {
                    required: true,
                    minlength: 5,
                },
                tahun_masuk: {
                    required: true,
                },
                no_telepon: {
                    required: true,
                    min: 3
                },
                nama: {
                    required: true,
                    minlength: 3,
                    maxlength: 100
                },
                avatar: {
                    required: false,
                },
            },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            dataUser.ajax.reload();
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
@endempty