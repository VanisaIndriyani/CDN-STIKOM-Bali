@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar bg-dark text-white" style="width: 250px; min-height: 100vh;">
            <div class="p-3 text-center">
                <img src="{{ asset('images/logo.png') }}" alt="STIKOM BALI" class="img-fluid mb-3" style="max-width: 150px;">
                <h5 class="fw-bold">Dashboard CDC STIKOM Bali</h5>
                <!-- <p class="small text-muted">Always The First</p> -->
            </div>
            <div class="nav flex-column p-2">
               
                <a href="{{ route('admin.alumni.index') }}" class="nav-link text-white py-2 mb-1 rounded">
                    <i class="bi bi-people me-2"></i> Kelola Alumni
                </a>
                <a href="{{ route('admin.reports') }}" class="nav-link text-white py-2 mb-1 rounded">
                    <i class="bi bi-file-text me-2"></i> Laporan
                </a>
               
            </div>
        <!-- </div> -->

        <!-- Main Content -->
        <div class="flex-grow-1 p-4" style="background-color: #f8f9fa;">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded shadow-sm">
                <h4 class="mb-0">Dashboard CDC STIKOM Bali</h4>
                <div class="d-flex align-items-center">
                    <div class="me-4">
                        <button class="btn btn-light me-2"><i class="bi bi-share"></i></button>
                        <button class="btn btn-light me-2"><i class="bi bi-calendar"></i></button>
                        <button class="btn btn-light"><i class="bi bi-printer"></i></button>
                    </div>
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" id="adminDropdown" data-bs-toggle="dropdown">
                            <img src="{{ asset('images/avatar.png') }}" alt="Admin" class="rounded-circle me-2" style="width: 40px;">
                            <span>Admin</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Edit Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('admin.logout') }}" method="POST" class="dropdown-item">
                                    @csrf
                                    <button type="submit" class="btn btn-link text-danger p-0">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4 g-3">
                <div class="col-md-4">
                    <div class="card stats-card">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white-50 mb-2">Total Alumni</h6>
                                    <h2 class="mb-0">10,267</h2>
                                    <p class="small text-white-50 mb-0">↑ 12% from last year</p>
                                </div>
                                <div class="stats-icon">
                                    <i class="bi bi-mortarboard"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card stats-card success">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white-50 mb-2">Total Responden</h6>
                                    <h2 class="mb-0">7,890</h2>
                                    <p class="small text-white-50 mb-0">↑ 8% from last month</p>
                                </div>
                                <div class="stats-icon">
                                    <i class="bi bi-people"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card stats-card info">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white-50 mb-2">Rata-rata Masa Tunggu</h6>
                                    <h2 class="mb-0">3.5 <small>bulan</small></h2>
                                    <p class="small text-white-50 mb-0">↓ 15% from last year</p>
                                </div>
                                <div class="stats-icon">
                                    <i class="bi bi-clock-history"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts -->
            <div class="row g-3">
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Trend Penyerapan Alumni per Tahun</h5>
                            <canvas id="employmentTrendChart"></canvas>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title">Distribusi Bidang Kerja</h5>
                                    <canvas id="jobFieldChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title">Rata-rata Gaji</h5>
                                    <canvas id="salaryChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Kesesuaian Kompetensi</h5>
                            <canvas id="competencyChart"></canvas>
                        </div>
                    </div>
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Status Pekerjaan</h5>
                            <canvas id="employmentStatusChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Employment Trend Chart
    new Chart(document.getElementById('employmentTrendChart'), {
        type: 'line',
        data: {
            labels: ['2019', '2020', '2021', '2022', '2023'],
            datasets: [{
                label: 'Tersalurkan',
                data: [650, 730, 800, 890, 950],
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.3,
                fill: true,
                backgroundColor: 'rgba(75, 192, 192, 0.1)'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' }
            }
        }
    });

    // Job Field Chart
    new Chart(document.getElementById('jobFieldChart'), {
        type: 'doughnut',
        data: {
            labels: ['Software Dev', 'Data Science', 'Network', 'UI/UX', 'Others'],
            datasets: [{
                data: [35, 25, 20, 15, 5],
                backgroundColor: [
                    '#FF6384',
                    '#36A2EB',
                    '#FFCE56',
                    '#4BC0C0',
                    '#9966FF'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    // Salary Chart
    new Chart(document.getElementById('salaryChart'), {
        type: 'bar',
        data: {
            labels: ['<5jt', '5-10jt', '10-15jt', '>15jt'],
            datasets: [{
                label: 'Jumlah Alumni',
                data: [30, 45, 15, 10],
                backgroundColor: 'rgba(54, 162, 235, 0.8)'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' }
            }
        }
    });

    // Competency Chart
    new Chart(document.getElementById('competencyChart'), {
        type: 'radar',
        data: {
            labels: ['Technical Skills', 'Soft Skills', 'Leadership', 'Innovation', 'Communication'],
            datasets: [{
                label: 'Kompetensi Alumni',
                data: [85, 75, 70, 80, 85],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgb(75, 192, 192)',
                pointBackgroundColor: 'rgb(75, 192, 192)'
            }]
        },
        options: {
            responsive: true,
            scales: {
                r: { beginAtZero: true }
            }
        }
    });

    // Employment Status Chart
    new Chart(document.getElementById('employmentStatusChart'), {
        type: 'pie',
        data: {
            labels: ['Full Time', 'Part Time', 'Freelance', 'Entrepreneur'],
            datasets: [{
                data: [70, 15, 10, 5],
                backgroundColor: [
                    '#4CAF50',
                    '#2196F3',
                    '#FFC107',
                    '#9C27B0'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>
@endpush
@endsection