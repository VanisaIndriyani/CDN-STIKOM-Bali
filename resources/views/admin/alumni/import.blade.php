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
                    <form action="{{ route('admin.alumni.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-bold">Pilih File Excel</label>
                            <div class="input-group">
                                <input type="file" name="file" class="form-control" required accept=".xlsx,.xls,.csv">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-upload me-2"></i>Import
                                </button>
                            </div>
                            <div class="form-text mt-2">
                                <i class="bi bi-info-circle me-1"></i>
                                Format yang didukung: .xlsx, .xls, .csv
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <h6 class="fw-bold"><i class="bi bi-lightbulb me-2"></i>Petunjuk Import:</h6>
                            <ol class="mb-0">
                                <li>Pastikan format file sesuai dengan template</li>
                                <li>Data harus memiliki kolom: Nama, NIM, Tahun Lulus, dll</li>
                                <li>Pastikan tidak ada baris kosong di file Excel</li>
                            </ol>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.alumni.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
