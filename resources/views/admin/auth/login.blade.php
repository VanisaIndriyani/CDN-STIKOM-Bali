@extends('layouts.app')

@section('content')
<div class="container-fluid vh-100">
    <div class="row h-100">
        <!-- Left side with background and logo -->
        <div class="col-md-7 d-flex flex-column justify-content-center align-items-center p-5 text-white" 
             style="background: linear-gradient(135deg, #6B4CE6 0%, #9B6DFF 100%);">
            <img src="{{ asset('images/logo.png') }}" alt="STIKOM BALI" class="img-fluid mb-4" style="max-width: 250px;">
            <h2 class="fw-bold mb-3">Selamat Datang di CDC STIKOM Bali</h2>
            <p class="lead text-center">Sistem Informasi Tracer Study dan Pusat Karir STIKOM Bali</p>
        </div>
        
        <!-- Right side with login form -->
        <div class="col-md-5 d-flex align-items-center" style="background-color: #f8f9fa;">
            <div class="w-100 p-5">
                <div class="text-center mb-4">
                    <h3 class="fw-bold">Login Admin</h3>
                    <p class="text-muted">Masuk ke dashboard admin</p>
                </div>

                <form method="POST" action="{{ route('admin.login.submit') }}" class="needs-validation" novalidate>
                    @csrf
                    <div class="mb-4">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-envelope" style="color: #6B4CE6"></i>
                            </span>
                            <input type="email" 
                                   name="email" 
                                   class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror" 
                                   placeholder="Email address"
                                   value="{{ old('email') }}" 
                                   required>
                        </div>
                        @error('email')
                            <div class="small text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-lock" style="color: #6B4CE6"></i>
                            </span>
                            <input type="password" 
                                   name="password" 
                                   class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror" 
                                   placeholder="Password"
                                   required>
                            <button class="btn btn-outline-secondary border border-start-0" type="button" onclick="togglePassword()">
                                <i class="bi bi-eye-slash" id="togglePassword"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="small text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn py-2 fw-bold text-white" 
                                style="background: linear-gradient(135deg, #6B4CE6 0%, #9B6DFF 100%);">
                            <i class="bi bi-box-arrow-in-right me-2"></i>LOGIN
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const password = document.querySelector('input[name="password"]');
    const toggleIcon = document.getElementById('togglePassword');
    
    if (password.type === 'password') {
        password.type = 'text';
        toggleIcon.classList.remove('bi-eye-slash');
        toggleIcon.classList.add('bi-eye');
    } else {
        password.type = 'password';
        toggleIcon.classList.remove('bi-eye');
        toggleIcon.classList.add('bi-eye-slash');
    }
}
</script>
@endsection