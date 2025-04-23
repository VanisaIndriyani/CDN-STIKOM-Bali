@extends('layouts.app')

@php
use App\Models\Alumni;
@endphp

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex h-100">
        <!-- Sidebar -->
        <div class="sidebar" style="width: 250px; min-height: 100vh; position: fixed; background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);">
            <div class="p-4 text-center">
                <img src="{{ asset('images/logo.png') }}" alt="STIKOM BALI" 
                     class="img-fluid mb-3" style="max-width: 120px; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));">
                <h5 class="fw-bold text-primary mb-4">Dashboard CDC STIKOM Bali</h5>
            </div>
            <div class="nav flex-column px-3">
                <a href="{{ route('admin.alumni.index') }}" 
                   class="nav-link mb-2 py-2 px-3 rounded-3 d-flex align-items-center {{ request()->routeIs('admin.alumni.*') ? 'active bg-primary text-white' : 'text-dark hover-link' }}"
                   style="transition: all 0.3s ease;">
                    <i class="bi bi-people me-3 fs-5"></i>
                    <span class="fw-medium">Kelola Alumni</span>
                </a>
                <a href="{{ route('admin.reports') }}" 
                   class="nav-link mb-2 py-2 px-3 rounded-3 d-flex align-items-center {{ request()->routeIs('admin.reports') ? 'active bg-primary text-white' : 'text-dark hover-link' }}"
                   style="transition: all 0.3s ease;">
                    <i class="bi bi-file-text me-3 fs-5"></i>
                    <span class="fw-medium">Laporan</span>
                </a>
            </div>
        </div>

        <!-- Add this style section at the bottom of your file -->
        <style>
            .hover-link {
                border: 1px solid transparent;
            }
            .hover-link:hover {
                background-color: #e9ecef;
                color: #0d6efd !important;
                transform: translateX(5px);
                border-color: #dee2e6;
            }
            .active {
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }
            .sidebar {
                border-right: 1px solid #e9ecef;
                box-shadow: 2px 0 8px rgba(0,0,0,0.05);
            }
        </style>

        <!-- Rest of your content -->
        <!-- Main Content -->
        <div class="flex-grow-1" style="margin-left: 250px; background-color: #f8f9fa; min-height: 100vh;">
            <div class="p-4">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded shadow-sm">
                    <h4 class="mb-0">Data Alumni</h4>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-primary p-2 me-3">
                            <i class="bi bi-people-fill me-2"></i>
                            Total: {{ $alumni->total() }}
                        </span>
                        <!-- Admin Profile Dropdown -->
                        <div class="dropdown">
                            <button class="btn btn-link text-dark text-decoration-none dropdown-toggle d-flex align-items-center" 
                                    type="button" 
                                    id="adminDropdown" 
                                    data-bs-toggle="dropdown" 
                                    aria-expanded="false">
                                <i class="bi bi-person-circle fs-5 me-2"></i>
                                <span>Admin</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="adminDropdown">
                                <li>
                                    <form action="{{ route('admin.logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item d-flex align-items-center">
                                            <i class="bi bi-box-arrow-right me-2"></i>
                                            Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-body bg-white rounded-3">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div class="d-flex gap-3">
                                   
                                    <form action="{{ route('admin.alumni.import') }}" method="POST" enctype="multipart/form-data" class="d-flex gap-2">
                                        @csrf
                                        <input type="file" name="file" class="form-control" required accept=".xlsx,.xls,.csv">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-cloud-upload-fill me-2"></i>Import
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <form action="{{ route('admin.alumni.index') }}" method="GET">
                                    <div class="input-group">
                                        <input type="text" 
                                               name="search" 
                                               class="form-control" 
                                               placeholder="Cari nama, NIM, pekerjaan..." 
                                               value="{{ request('search') }}">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alumni Table -->
                <div class="card shadow-sm border-0">
                    <div class="card-body bg-white rounded-3 p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="px-4 py-3">Nama</th>
                                        <th class="py-3">NIM</th>
                                        <th class="py-3">Tahun Lulus</th>
                                        <th class="py-3">Periode Wisuda</th>
                                        <th class="py-3">Tahun Yudisium</th>
                                        <th class="py-3">Pekerjaan</th>
                                        <th class="py-3">Perusahaan</th>
                                        <th class="py-3">Bidang</th>
                                        <th class="py-3">Relevansi</th>
                                        <th class="px-4 py-3 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($alumni as $alum)
                                    <tr>
                                        <td class="px-4">{{ $alum->nama }}</td>
                                        <td>{{ $alum->nim }}</td>
                                        <td>{{ $alum->tahun_lulus }}</td>
                                        <td>{{ $alum->periode_wisuda ?: '-' }}</td>
                                        <td>{{ $alum->tahun_yudisium ?: '-' }}</td>
                                        <td>{{ $alum->pekerjaan ?: '-' }}</td>
                                        <td>{{ $alum->perusahaan ?: '-' }}</td>
                                        <td>{{ $alum->bidang ?: '-' }}</td>
                                        <td>
                                            @if($alum->relevansi)
                                                <span class="badge bg-success">Sesuai</span>
                                            @else
                                                <span class="badge bg-warning">Tidak Sesuai</span>
                                            @endif
                                        </td>
                                        <td class="px-4 text-center">
                                            <div class="btn-group">
                                                <button type="button" 
                                                        class="btn btn-sm btn-danger delete-alumni" 
                                                        data-id="{{ $alum->id }}"
                                                        data-bs-toggle="tooltip" 
                                                        title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="bi bi-info-circle me-2"></i>Tidak ada data alumni
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        @if($alumni->hasPages())
                        <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top">
                            <div class="small text-muted">
                                Showing {{ $alumni->firstItem() }} to {{ $alumni->lastItem() }} of {{ $alumni->total() }} entries
                            </div>
                            <div>
                                {{ $alumni->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
@push('scripts')
<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    // Delete Alumni Handler
    document.querySelectorAll('.delete-alumni').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            
            if (confirm('Yakin ingin menghapus?')) {
                fetch(`/admin/alumni/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove the table row
                        this.closest('tr').remove();
                        
                        // Update the total count
                        const totalElement = document.querySelector('.badge.bg-primary');
                        const currentTotal = parseInt(totalElement.textContent.match(/\d+/)[0]);
                        totalElement.innerHTML = `<i class="bi bi-people-fill me-2"></i>Total: ${currentTotal - 1}`;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menghapus data');
                });
            }
        });
    });
</script>
@endpush

    </div>
</div>