@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex">
        <!-- Include the sidebar -->
        @include('layouts.sidebar')
        
        <!-- Rest of your content -->
        <div class="flex-grow-1 p-4" style="background-color: #f8f9fa;">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded shadow-sm">
                <h4 class="mb-0">Edit Data Alumni</h4>
            </div>

            <!-- Form Card -->
            <div class="card shadow-sm border-0">
                <div class="card-body bg-white rounded-3 p-4">
                    <form action="{{ route('admin.alumni.update', $alumni->id) }}" method="POST" class="row g-4">
                        @csrf
                        @method('PUT')
                        
                        <!-- Personal Information -->
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-primary text-white py-3">
                                    <h5 class="card-title mb-0"><i class="bi bi-person-vcard me-2"></i>Informasi Pribadi</h5>
                                </div>
                                <div class="card-body p-4">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Nama Lengkap</label>
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $alumni->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">NIM</label>
                                        <input type="text" name="nim" class="form-control @error('nim') is-invalid @enderror" value="{{ old('nim', $alumni->nim) }}" required>
                                        @error('nim')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label class="form-label fw-bold">Jenis Kelamin</label>
                                            <select name="gender" class="form-select @error('gender') is-invalid @enderror" required>
                                                <option value="">Pilih</option>
                                                <option value="male" {{ old('gender', $alumni->gender) == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                                <option value="female" {{ old('gender', $alumni->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                                            </select>
                                            @error('gender')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Employment Information -->
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-success text-white py-3">
                                    <h5 class="card-title mb-0"><i class="bi bi-briefcase me-2"></i>Informasi Pekerjaan</h5>
                                </div>
                                <div class="card-body p-4">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Pekerjaan Saat Ini</label>
                                        <input type="text" name="current_job" class="form-control @error('current_job') is-invalid @enderror" value="{{ old('current_job', $alumni->current_job) }}">
                                        @error('current_job')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Perusahaan</label>
                                        <input type="text" name="company" class="form-control @error('company') is-invalid @enderror" value="{{ old('company', $alumni->company) }}">
                                        @error('company')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Relevansi dengan Jurusan</label>
                                        <input type="text" name="job_relevance" class="form-control @error('job_relevance') is-invalid @enderror" value="{{ old('job_relevance', $alumni->job_relevance) }}">
                                        @error('job_relevance')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.alumni.index') }}" class="btn btn-light">
                                        <i class="bi bi-arrow-left me-2"></i>Kembali
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save me-2"></i>Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection