@extends('layouts.t_template')

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
                        <form action="{{ route('tUpdateKompen.TugasSelesai', $item['id_progres_tugas']) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Tugas Selesai</button>
                        </form>
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
