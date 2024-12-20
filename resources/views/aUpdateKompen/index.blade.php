@extends('layouts.a_template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
    </div>
    <div class="card-body">
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <script>
            setTimeout(() => {
                document.querySelector('.alert-success').classList.remove('fade');
            }, 500);
        </script>
        @endif
        @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <script>
            setTimeout(() => {
                document.querySelector('.alert-danger').classList.remove('fade');
            }, 500);
        </script>
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
                <tr>
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
                        @if ($item['status'] === 'selesai')
                            <span class="badge bg-success">Selesai</span>
                        @else
                            <form action="{{ route('aUpdateKompen.TugasSelesai', $item['id_progres_tugas']) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Tugas Selesai</button>
                            </form>
                            <form action="{{ route('aUpdateKompen.KompenDiterima', $item['id_riwayat']) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm"
                                    @if ($item['status'] === 'diterima') disabled @endif>
                                    Kompen Diterima
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
    data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection
