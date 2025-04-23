@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar bg-dark text-white" style="width: 250px; min-height: 100vh;">
            <div class="p-3 text-center">
                <img src="{{ asset('images/logo.png') }}" alt="STIKOM BALI" class="img-fluid mb-3" style="max-width: 150px;">
                <h5 class="fw-bold">Dashboard CDC STIKOM Bali</h5>
            </div>
            <div class="nav flex-column p-2">
                <a href="{{ route('admin.alumni.index') }}" class="nav-link text-white py-2 mb-1 rounded">
                    <i class="bi bi-people me-2"></i> Kelola Alumni
                </a>
                <a href="{{ route('admin.reports') }}" class="nav-link text-white py-2 mb-1 rounded">
                    <i class="bi bi-file-text me-2"></i> Laporan
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-grow-1 p-4" style="background-color: #f8f9fa;">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-primary text-white py-3">
                            <h5 class="card-title mb-0"><i class="bi bi-person-circle me-2"></i>Edit Profile</h5>
                        </div>
                        <div class="card-body p-4">
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                
                                <div class="text-center mb-4">
                                    <div class="position-relative d-inline-block">
                                        <img src="{{ auth()->user()->avatar ? asset(auth()->user()->avatar) : asset('images/avatar.png') }}" 
                                             class="rounded-circle border shadow-sm mb-3" 
                                             style="width: 180px; height: 180px; object-fit: cover;" 
                                             id="avatar-preview">
                                        <label class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-2 cursor-pointer" 
                                               style="cursor: pointer;">
                                            <i class="bi bi-camera"></i>
                                            <input type="file" name="avatar" class="d-none" onchange="previewImage(this)">
                                        </label>
                                    </div>
                                    <p class="text-muted small">Click the camera icon to change profile picture</p>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold">Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}" required>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                        <input type="email" class="form-control" value="{{ auth()->user()->email }}" disabled>
                                    </div>
                                    <small class="text-muted">Email cannot be changed</small>
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.alumni.index') }}" class="btn btn-light">
                                        <i class="bi bi-arrow-left me-2"></i>Back
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save me-2"></i>Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatar-preview').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection