@extends('layouts.app')

@section('content')
<div class="container-fluid p-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-person-plus me-2"></i>Tambah Data Alumni</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.alumni.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">NIM</label>
                                <input type="text" name="nim" class="form-control" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Tahun Lulus</label>
                                <input type="number" name="tahun_lulus" class="form-control" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Tahun Yudisium</label>
                                <input type="number" name="tahun_yudisium" class="form-control" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Periode Wisuda</label>
                                <input type="text" name="periode_wisuda" class="form-control" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Pekerjaan</label>
                                <input type="text" name="pekerjaan" class="form-control">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Perusahaan</label>
                                <input type="text" name="perusahaan" class="form-control">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Bidang</label>
                                <input type="text" name="bidang" class="form-control">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Rata-rata Gaji</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="rata_rata_gaji" class="form-control" placeholder="0" min="0" step="100000">
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="form-check">
                                    <input type="checkbox" name="relevansi" class="form-check-input" value="1">
                                    <label class="form-check-label">Relevan dengan jurusan</label>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save me-2"></i>Simpan
                            </button>
                            <a href="{{ route('admin.alumni.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection