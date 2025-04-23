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
                    <h4 class="mb-0">Edit Profile</h4>
                </div>

                <!-- Profile Form -->
                <div class="card shadow-sm border-0">
                    <div class="card-body bg-white rounded-3">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-4 text-center">
                                <div class="position-relative d-inline-block">
                                    <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('images/avatar.png') }}" 
                                         alt="Profile Picture" 
                                         class="rounded-circle mb-3 shadow-sm"
                                         style="width: 150px; height: 150px; object-fit: cover;"
                                         id="avatar-preview">
                                    <label for="avatar" class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-2 cursor-pointer">
                                        <i class="bi bi-camera-fill"></i>
                                        <input type="file" id="avatar" name="avatar" class="d-none" accept="image/*">
                                    </label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $user->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $user->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password Baru</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password">
                                <div class="form-text">Kosongkan jika tidak ingin mengubah password</div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                <input type="password" class="form-control" 
                                       id="password_confirmation" name="password_confirmation">
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>Simpan Perubahan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('avatar').onchange = function(evt) {
        const [file] = this.files;
        if (file) {
            document.getElementById('avatar-preview').src = URL.createObjectURL(file);
        }
    }
</script>
@endpush