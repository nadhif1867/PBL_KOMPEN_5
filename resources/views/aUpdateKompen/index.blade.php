@extends('layouts.a_template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
    </div>
    <div class="card-body">
        @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered table-striped table-hover table-sm">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Nama Tugas</th>
                    <th class="text-center">Nama Mahasiswa</th>
                    <th class="text-center">Pemberi Tugas</th>
                    <th class="text-center">Progres</th>
                    <th class="text-center">Berita Acara</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                <tr id="row-{{ $item['id_progres_tugas'] }}">
                    <td class="text-center">{{ $item['no'] }}</td>
                    <td class="text-center">{{ $item['nama_tugas'] }}</td>
                    <td class="text-center">{{ $item['nama_mahasiswa'] }}</td>
                    <td class="text-center">{{ $item['pemberi_tugas'] }}</td>
                    <td class="text-center">{{ $item['progres'] }}</td>

                    <td class="text-center">
                        @if ($item['berita_acara'])
                            <a href="{{ $item['berita_acara'] }}" target="_blank">
                                <i class="fas fa-file text-primary fa-2x"></i>
                            </a>
                        @else
                            <span>-</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($item['status'] !== 'selesai')
                        <button class="btn btn-success btn-sm"
                                data-toggle="modal"
                                data-target="#konfirmasiModal"
                                data-id="{{ $item['id_progres_tugas'] }}">
                            Tugas Selesai
                        </button>
                        @else
                            <span>Tugas sudah selesai</span>
                        @endif

                        <form action="{{ route('aUpdateKompen.KompenDiterima', $item['id_riwayat']) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-sm">Kompen Diterima</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Konfirmasi -->
<div class="modal fade" id="konfirmasiModal" tabindex="-1" role="dialog" aria-labelledby="konfirmasiModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="konfirmasiModalLabel">Konfirmasi Penyelesaian Tugas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menandai tugas ini sebagai selesai?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" id="confirmSelesaiBtn" class="btn btn-primary">Ya, Selesai</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#konfirmasiModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var idProgres = button.data('id');
            $('#confirmSelesaiBtn').data('id', idProgres);
        });

        // Event klik tombol "Ya, Selesai"
        $('#confirmSelesaiBtn').on('click', function () {
            var idProgres = $(this).data('id');

            // Kirim request AJAX ke server
            $.ajax({
                url: '{{ route("aUpdateKompen.TugasSelesai", ":id") }}'.replace(':id', idProgres),
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.success) {
                        // Sembunyikan tombol dan ganti teks di baris
                        $('#row-' + idProgres).html('<td colspan="7" class="text-center">Tugas Selesai</td>');
                        $('#konfirmasiModal').modal('hide');
                        alert(response.message);
                    } else {
                        alert(response.message);
                    }
                },
                error: function () {
                    alert('Gagal menyelesaikan tugas. Silakan coba lagi.');
                }
            });
        });
    });
</script>
@endpush
