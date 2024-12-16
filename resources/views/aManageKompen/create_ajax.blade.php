<form action="{{ url('/aManageKompen/ajax') }}" method="POST" id="form-tambah">
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
                    <label>Admin</label>
                    <select name="id_admin" id="id_admin" class="form-control" required>
                        <option value="">- Pilih Kompen -</option>
                        @foreach ($aAdmin as $a)
                        <option value="{{ $a->id_admin }}">{{ $a->nama }}</option>
                        @endforeach
                    </select>
                    <small id="error-id_admin" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Nama Tugas</label>
                    <input value="" type="text" name="nama_tugas" id="nama_tugas" class="form-control"
                        required>
                    <small id="error-nama_tugas" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <input value="" type="text" name="deskripsi" id="deskripsi" class="form-control"
                        required>
                    <small id="error-deskripsi" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="">- Pilih Status -</option>
                        <option value="dibuka">Dibuka</option>
                        <option value="ditutup">Ditutup</option>
                    </select>
                    <small id="error-status" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Tanggal Mulai</label>
                    <input value="" type="datetime-local" name="tanggal_mulai" id="tanggal_mulai" class="form-control"
                        required>
                    <small id="error-tanggal_mulai" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Tanggal Selesai</label>
                    <input value="" type="datetime-local" name="tanggal_selesai" id="tanggal_selesai" class="form-control"
                        required>
                    <small id="error-tanggal_selesai" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Jam Kompen</label>
                    <input value="" type="text" name="jam_kompen" id="jam_kompen" class="form-control"
                        required>
                    <small id="error-jam_kompen" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Kuota</label>
                    <input value="" type="number" name="kuota" id="kuota" class="form-control"
                        required>
                    <small id="error-kuota" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Bidang Kompetensi</label>
                    <select name="id_bidkom" id="id_bidkom" class="form-control" required>
                        <option value="">- Pilih Bidang Kompetensi -</option>
                        @foreach ($aBidangKompetensi as $b)
                        <option value="{{ $b->id_bidkom }}">{{ $b->tag_bidkom }}</option>
                        @endforeach
                    </select>
                    <small id="error-id_bidkom" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Jenis Kompen</label>
                    <select name="id_jenis_kompen" id="id_jenis_kompen" class="form-control" required>
                        <option value="">- Pilih Kompen -</option>
                        @foreach ($aJenisKompen as $j)
                        <option value="{{ $j->id_jenis_kompen }}">{{ $j->jenis_kompen }}</option>
                        @endforeach
                    </select>
                    <small id="error-id_jenis_kompen" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Jenis Kompen</label>
                    <select name="id_periode" id="id_periode" class="form-control" required>
                        <option value="">- Pilih Periode -</option>
                        @foreach ($aPeriodeAkademik as $p)
                        <option value="{{ $p->id_periode }}">{{ $p->tahun_ajaran }}</option>
                        @endforeach
                    </select>
                    <small id="error-id_periode" class="error-text form-text text-danger"></small>
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
                id_admin: {
                    required: true,
                    number: true,
                },
                nama_tugas: {
                    required: true,
                },
                deskripsi: {
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
                },
                jam_kompen: {
                    required: true,
                },
                kuota: {
                    required: true,
                },
                id_bidkom: {
                    required: true,
                    number: true,
                },
                id_jenis_kompen: {
                    required: true,
                    number: true,
                },
                id_periode: {
                    required: true,
                    number: true,
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action, // Ensure this points to the correct URL
                    type: 'POST',
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
                return false; // Prevent the form from submitting the traditional way
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