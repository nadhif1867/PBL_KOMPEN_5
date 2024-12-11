<form action="{{ url('/aManageMahasiswaKompen/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Mahasiswa</label>
                    <select name="id_mahasiswa" id="id_mahasiswa" class="form-control" required>
                        <option value="">- Pilih User -</option>
                        @foreach ($aMahasiswa as $l)
                        <option value="{{ $l->id_mahasiswa }}">{{ $l->nama }}</option>
                        @endforeach
                    </select>
                    <small id="error-id_mahasiswa" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Jumlah Alpha</label>
                    <input value="" type="number" name="jumlah_alpha" id="jumlah_alpha" class="form-control"
                        required>
                    <small id="error-jumlah_alpha" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Kompen Terbayar</label>
                    <input value="" type="number" name="kompen_dibayar" id="kompen_dibayar" class="form-control"
                        required>
                    <small id="error-kompen_dibayar" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Periode</label>
                    <select name="id_periode" id="id_periode" class="form-control" required>
                        <option value="">- Pilih User -</option>
                        @foreach ($aPeriodeAkademik as $l)
                        <option value="{{ $l->id_periode }}">{{ $l->tahun_ajaran }}</option>
                        @endforeach
                    </select>
                    <small id="error-user_id" class="error-text form-text text-danger"></small>
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
        $("#form-tambah").validate({
            rules: {
                id_mahasiswa: {
                    required: true,
                    number: true
                },
                jumlah_alpha: {
                    required: true,
                    number: true
                },
                kompen_dibayar: {
                    required: true,
                    number: true
                },
                id_periode: {
                    required: true,
                    date: true,
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
                            tableStok.ajax.reload();
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