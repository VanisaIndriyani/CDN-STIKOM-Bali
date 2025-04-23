@extends('layouts.user')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Statistik Alumni</h2>
    
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Alumni per Tahun Lulus</h5>
                    <canvas id="graduationYearChart"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Distribusi Bidang Pekerjaan</h5>
                    <canvas id="jobFieldChart"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Distribusi Gender</h5>
                    <canvas id="genderChart"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Relevansi Pekerjaan</h5>
                    <canvas id="relevanceChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Graduation Year Chart
    new Chart(document.getElementById('graduationYearChart'), {
        type: 'bar',
        data: {
            labels: ['2020', '2021', '2022', '2023', '2024'],
            datasets: [{
                label: 'Jumlah Alumni',
                data: [65, 80, 75, 90, 85],
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgb(54, 162, 235)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Job Field Chart
    new Chart(document.getElementById('jobFieldChart'), {
        type: 'pie',
        data: {
            labels: ['IT Developer', 'Data Analyst', 'Network Engineer', 'UI/UX Designer', 'Others'],
            datasets: [{
                data: [30, 20, 15, 15, 20],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 206, 86, 0.8)',
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(153, 102, 255, 0.8)'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Gender Distribution Chart
    new Chart(document.getElementById('genderChart'), {
        type: 'doughnut',
        data: {
            labels: ['Laki-laki', 'Perempuan'],
            datasets: [{
                data: [60, 40],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 99, 132, 0.8)'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Job Relevance Chart
    new Chart(document.getElementById('relevanceChart'), {
        type: 'radar',
        data: {
            labels: ['Sangat Relevan', 'Relevan', 'Cukup Relevan', 'Kurang Relevan', 'Tidak Relevan'],
            datasets: [{
                label: 'Tingkat Relevansi',
                data: [40, 30, 15, 10, 5],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgb(75, 192, 192)',
                pointBackgroundColor: 'rgb(75, 192, 192)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgb(75, 192, 192)'
            }]
        },
        options: {
            responsive: true,
            scales: {
                r: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endpush
@endsection