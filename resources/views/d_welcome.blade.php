@extends('layouts.d_template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $breadcrumb->title }}</h3>
        <div class="card-tools">
            <span>{{ implode(' / ', $breadcrumb->list) }}</span>
        </div>
    </div>


    <div class="card-body">
        <div class="row">
            <!-- Kartu Statistik -->
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="info-box bg-primary">
                    <span class="info-box-icon"><i class="fas fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Mahasiswa Alpha </span>
                        <span class="info-box-number">{{ $data['totalMahasiswaAlpha'] }} Orang</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="info-box bg-success">
                    <span class="info-box-icon"><i class="fas fa-check-circle"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Mahasiswa yang Telah Kompen</span>
                        <span class="info-box-number">{{ $data['mahasiswaSelesai'] }} Orang</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik -->
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="card-title">Rata-Rata Jumlah Mahasiswa Kompen Tiap Periode Semester</h3>
            </div>
            <div class="card-body">
                <canvas id="grafikKompen" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- @push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('grafikKompen').getContext('2d');
    const grafikKompen = new Chart(ctx, {
        type: 'line', data: {
            labels: {!! json_encode(array_column($grafik, 'periode')) !!},
            datasets: [{
                label: 'Jumlah Mahasiswa Kompen',
                data: {!! json_encode(array_column($grafik, 'jumlah')) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah Mahasiswa Kompen'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Periode Semester'
                    }
                }
            }
        }
    });
</script>
@endpush -->
