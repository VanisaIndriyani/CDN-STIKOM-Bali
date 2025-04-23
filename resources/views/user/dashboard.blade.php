@extends('layouts.user')

@section('content')
<div class="container-fluid py-4" style="background-color: #f8f9fa;">
    <!-- Header with enhanced styling -->
    <div class="text-center mb-5">
        <img src="{{ asset('images/logo.png') }}" alt="STIKOM BALI" class="img-fluid mb-3" style="max-width: 150px;">
        <h2 class="fw-bold text-primary">Tracer Study STIKOM Bali</h2>
        <p class="text-muted lead">Statistik dan Analisis Data Alumni</p>
        <div class="border-bottom border-2 w-25 mx-auto my-4"></div>
    </div>

    <!-- Enhanced Summary Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card h-100 shadow-sm hover-shadow" style="border-radius: 15px; border: none; transition: all 0.3s;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                            <i class="bi bi-people-fill text-primary fs-3"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted mb-1 small text-uppercase">Total Alumni</h6>
                            <h3 class="mb-0 fw-bold text-primary">{{ number_format($summary['total_alumni']) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Similar enhancements for other cards -->
        <div class="col-md-3">
            <div class="card h-100 shadow-sm hover-shadow" style="border-radius: 15px; border: none; transition: all 0.3s;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-success bg-opacity-10 p-3">
                            <i class="bi bi-briefcase-fill text-success fs-3"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted mb-1 small text-uppercase">Sudah Bekerja</h6>
                            <h3 class="mb-0 fw-bold text-success">{{ number_format($summary['employed']) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-info bg-opacity-10 p-3">
                            <i class="bi bi-cash-stack text-info fs-4"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted mb-1">Rata-rata Gaji</h6>
                            <h3 class="mb-0">{{ number_format($summary['avg_salary']/1000000, 1) }}jt</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                            <i class="bi bi-clock text-warning fs-4"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="text-muted mb-1">Rata-rata Masa Tunggu</h6>
                            <h3 class="mb-0">{{ number_format($summary['avg_waiting_time'], 1) }} bln</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Charts Section -->
    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="card shadow-sm h-100" style="border-radius: 15px; border: none;">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-4 text-primary">
                        <i class="bi bi-pie-chart-fill me-2"></i>
                        Distribusi Bidang Pekerjaan
                    </h5>
                    <canvas id="jobFieldChart" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm h-100" style="border-radius: 15px; border: none;">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-4 text-primary">
                        <i class="bi bi-cash me-2"></i>
                        Distribusi Gaji
                    </h5>
                    <canvas id="salaryChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Yearly Trend -->
    <div class="card shadow-sm mb-5" style="border-radius: 15px; border: none;">
        <div class="card-body">
            <h5 class="card-title fw-bold mb-4 text-primary">
                <i class="bi bi-graph-up me-2"></i>
                Tren Alumni per Tahun
            </h5>
            <canvas id="yearlyChart"></canvas>
        </div>
    </div>

    <!-- Enhanced Additional Stats -->
    <div class="card shadow-sm" style="border-radius: 15px; border: none;">
        <div class="card-body">
            <h5 class="card-title fw-bold mb-4 text-primary">
                <i class="bi bi-check2-circle me-2"></i>
                Statistik Kesesuaian Bidang Pekerjaan
            </h5>
            <canvas id="relevanceChart"></canvas>
        </div>
    </div>
</div>

<style>
.hover-shadow:hover {
    transform: translateY(-5px);
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
}

.card {
    overflow: hidden;
}

.card-title {
    position: relative;
    padding-bottom: 10px;
}

.card-title:after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 50px;
    height: 3px;
    background: #4e73df;
    border-radius: 3px;
}
</style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Enhanced Chart Configurations
    Chart.defaults.font.family = "'Poppins', sans-serif";
    Chart.defaults.color = '#666';

    // Enhanced Salary Distribution Chart
    const salaryChart = new Chart(document.getElementById('salaryChart'), {
        type: 'bar',
        data: {
            labels: ["< 5 Juta", "5-10 Juta", "10-15 Juta"],
            datasets: [{
                label: 'Jumlah Alumni',
                data: [2, 7, 1],
                backgroundColor: ['rgba(78, 115, 223, 0.8)', 'rgba(28, 200, 138, 0.8)', 'rgba(54, 185, 204, 0.8)'],
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });

    // Enhanced Yearly Trend Chart
    const yearlyChart = new Chart(document.getElementById('yearlyChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($yearlyStats->pluck('tahun_lulus')) !!},
            datasets: [{
                label: 'Jumlah Alumni',
                data: {!! json_encode($yearlyStats->pluck('total')) !!},
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78, 115, 223, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#4e73df',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });

    // Job Field Distribution Chart
    const jobFieldChart = new Chart(document.getElementById('jobFieldChart'), {
        type: 'pie',
        data: {
            labels: {!! json_encode($jobFields->pluck('bidang')) !!},
            datasets: [{
                data: {!! json_encode($jobFields->pluck('total')) !!},
                backgroundColor: [
                    'rgba(78, 115, 223, 0.8)',
                    'rgba(28, 200, 138, 0.8)',
                    'rgba(54, 185, 204, 0.8)',
                    'rgba(246, 194, 62, 0.8)',
                    'rgba(231, 74, 59, 0.8)',
                    'rgba(133, 135, 150, 0.8)'
                ],
                borderWidth: 1,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                }
            }
        }
    });

    // Job Field Relevance Chart
    const relevanceChart = new Chart(document.getElementById('relevanceChart'), {
        type: 'doughnut',
        data: {
            labels: ['Sangat Sesuai', 'Sesuai', 'Kurang Sesuai', 'Tidak Sesuai'],
            datasets: [{
                data: {!! json_encode($jobFields->pluck('total')) !!},
                backgroundColor: [
                    'rgba(28, 200, 138, 0.8)',  // Green for Sangat Sesuai
                    'rgba(78, 115, 223, 0.8)',   // Blue for Sesuai
                    'rgba(246, 194, 62, 0.8)',   // Yellow for Kurang Sesuai
                    'rgba(231, 74, 59, 0.8)'     // Red for Tidak Sesuai
                ],
                borderWidth: 1,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            cutout: '60%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value * 100) / total).toFixed(1);
                            return `${label}: ${percentage}%`;
                        }
                    }
                }
            }
        }
    });
</script>
@endpush