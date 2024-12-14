@extends('layouts.m_template')

@section('content')

<div class="card">
    @extends('layouts.m_template')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="card-title mb-0">Overview Kompen Kamu</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card bg-danger text-white">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-exclamation-triangle-fill fs-1 me-3"></i>
                                        <div>
                                            <h5 class="card-title">Jam Alpha</h5>
                                            <h3 class="card-text">{{ $jumlahAlpha }} Jam</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-check-circle-fill fs-1 me-3"></i>
                                        <div>
                                            <h5 class="card-title">Kompen Selesai</h5>
                                            <h3 class="card-text">{{ $kompenSelesai }} Jam</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
@endsection
