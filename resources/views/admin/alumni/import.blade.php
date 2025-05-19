@extends('layouts.app')

@section('content')
<div class="container-fluid p-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-upload me-2"></i>Import Data Alumni</h5>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.alumni.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-bold">Pilih File Excel</label>
                            <div class="input-group">
                                <input type="file" 
                                       name="file" 
                                       class="form-control @error('file') is-invalid @enderror" 
                                       required 
                                       accept=".xlsx,.xls">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-upload me-2"></i>Import
                                </button>
                            </div>
                            @error('file')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                            <div id="uploadStatus" class="mt-2"></div>
                        </div>
                    </form>

                    <div class="form-text mt-2">
                        <i class="bi bi-info-circle me-1"></i>
                        Format yang didukung: .xlsx, .xls
                    </div>

                    <div class="alert alert-info">
                        <h6 class="fw-bold"><i class="bi bi-lightbulb me-2"></i>Petunjuk Import:</h6>
                        <ol class="mb-0">
                            <li>Pastikan menggunakan template yang benar</li>
                            <li>Data harus memiliki kolom berikut:
                                <ul class="mt-2">
                                    <li>Nama (wajib)</li>
                                    <li>NIM (wajib, unik)</li>
                                    <li>Tahun Lulus (wajib, angka)</li>
                                    <li>Periode Wisuda (wajib)</li>
                                    <li>Tahun Yudisium (wajib, angka)</li>
                                    <li>Pekerjaan (opsional)</li>
                                    <li>Perusahaan (opsional)</li>
                                    <li>Bidang (opsional)</li>
                                    <li>Rata-rata Gaji (opsional, angka)</li>
                                    <li>Relevansi (opsional, true/false)</li>
                                </ul>
                            </li>
                            <li>Baris pertama harus berisi nama kolom</li>
                            <li>Data dimulai dari baris kedua</li>
                            <li>Pastikan tidak ada baris kosong di tengah data</li>
                        </ol>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.alumni.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                    <div class="mt-4">
                        <a href="{{ route('admin.alumni.template') }}" class="btn btn-outline-primary me-2">
                            <i class="bi bi-download me-2"></i>Download Template Kosong
                        </a>
                        <a href="{{ route('admin.alumni.generate-sample') }}" class="btn btn-outline-success">
                            <i class="bi bi-download me-2"></i>Download Contoh Data
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.querySelector('form').addEventListener('submit', function(e) {
    const fileInput = document.querySelector('input[type="file"]');
    const uploadStatus = document.getElementById('uploadStatus');
    
    if (fileInput.files.length > 0) {
        uploadStatus.innerHTML = '<div class="alert alert-info">Sedang mengupload dan memproses data...</div>';
    }
});
</script>
@endsection
