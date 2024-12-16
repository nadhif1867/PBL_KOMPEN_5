@extends('layouts.a_template')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Periode</th>
                    <th>Tahun</th>
                    <th>Unduh Report</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $row)
                <tr>
                    <td>{{ $row->id_periode}}</td>
                    <td>{{ $row->semester }}</td>
                    <td>{{ $row->tahun_ajaran }}</td>
                    <td>
                        <a href="{{ route('report.exportPDF', ['id_periode' => $row->id_periode]) }}"
                            class="btn btn-primary btn-sm">
                            <i class="fas fa-download"></i>
                         </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
