@empty($aTugasTendik)
<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger">
                <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>Data yang anda cari tidak ditemukan
            </div>
            <a href="{{ url('/tManageKompen') }}" class="btn btn-warning">Kembali</a>
        </div>
    </div>
</div>
@else
<form action="{{ url('/tManageKompen/' . $aTugasTendik->id_tugas_tendik . '/update_ajax') }}" method="POST" id="form-edit">
    @csrf
    @method('PUT')
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Kompen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Tugas</label>
                    <input value="{{ $aTugasTendik->nama_tugas }}" type="text" name="nama_tugas" id="nama_tugas" class="form-control" required>
                    <small id="error-nama_tugas" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Deskripsi</label>
                    <input value="{{ $aTugasTendik->deskripsi }}" type="text" name="deskripsi" id="deskripsi" class="form-control" required>
                    <small id="error-jumlah_alpha" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Kuota</label>
                    <input value="{{ $aTugasTendik->kuota }}" type="text" name="kuota" id="kuota" class="form-control" required>
                    <small id="error-kuota" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Jam Kompen</label>
                    <input value="{{ $aTugasTendik->jam_kompen }}" type="text" name="jam_kompen" id="jam_kompen" class="form-control" required>
                    <small id="error-jam_kompen" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Status</label>
                    <input value="{{ $aTugasTendik->status }}" type="text" name="status" id="status" class="form-control" required>
                    <small id="error-status" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Waktu Mulai Pengerjaan</label>
                    <input value="{{ $aTugasTendik->tanggal_mulai }}" type="datetime-local" name="tanggal_mulai" id="tanggal_mulai" class="form-control">
                    <small id="error-tanggal_mulai" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Waktu Selesai Pengerjaan</label>
                    <input value="{{ $aTugasTendik->tanggal_selesai }}" type="datetime-local" name="tanggal_selesai" id="tanggal_selesai" class="form-control">
                    <small id="error-tanggal_selesai" class="error-text form-text text-danger"></small>
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
                nama_tugas: {
                    required: true,
                },
                deskripsi: {
                    required: true,
                },
                kuota: {
                    required: true,
                },
                jam_kompen: {
                    required: true,
                },
                status: {
                    required: true,
                },
                tanggal_mulai: {
                    required: true,
                },
                tanggal_selesai: {
                    required: true,
                }
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
                            dataLevel.ajax.reload();
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