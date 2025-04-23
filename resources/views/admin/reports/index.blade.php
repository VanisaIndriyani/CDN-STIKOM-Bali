@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex h-100">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <div class="flex-grow-1" style="margin-left: 250px; background-color: #f8f9fa; min-height: 100vh;">
            <div class="p-4">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded shadow-sm">
                    <h4 class="mb-0">Laporan Statistik Alumni</h4>
                    <div>
                        <!-- <a href="{{ route('admin.reports.excel') }}" class="btn btn-success me-2">
                            <i class="bi bi-file-excel me-2"></i>Export Excel
                        </a>
                        <a href="{{ route('admin.reports.pdf') }}" class="btn btn-danger">
                            <i class="bi bi-file-pdf me-2"></i>Export PDF
                        </a> -->
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm bg-primary text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="card-title mb-2">Total Alumni</h6>
                                        <h2 class="mb-0">{{ number_format($statistics->total_alumni) }}</h2>
                                    </div>
                                    <div class="bg-white rounded-circle p-2">
                                        <i class="bi bi-people text-primary fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm bg-success text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="card-title mb-2">Alumni Bekerja</h6>
                                        <h2 class="mb-0">{{ number_format($statistics->working_alumni) }}</h2>
                                    </div>
                                    <div class="bg-white rounded-circle p-2">
                                        <i class="bi bi-briefcase text-success fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm bg-info text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="card-title mb-2">Relevansi Pekerjaan</h6>
                                        <h2 class="mb-0">{{ number_format($statistics->relevance_percentage, 1) }}%</h2>
                                    </div>
                                    <div class="bg-white rounded-circle p-2">
                                        <i class="bi bi-graph-up text-info fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Yearly Statistics Table -->
                <div class="card shadow-sm border-0">
                    <div class="card-body bg-white rounded-3">
                        <h5 class="card-title mb-4">Statistik Per Tahun</h5>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Tahun Lulus</th>
                                        <th>Total Alumni</th>
                                        <th>Bekerja</th>
                                        <th>Relevan</th>
                                        <th>% Relevansi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($yearlyData as $data)
                                    <tr>
                                        <td>{{ $data->year }}</td>
                                        <td>{{ number_format($data->total) }}</td>
                                        <td>{{ number_format($data->working) }}</td>
                                        <td>{{ number_format($data->relevant) }}</td>
                                        <td>{{ number_format(($data->relevant / $data->total) * 100, 1) }}%</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection