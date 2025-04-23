<div class="sidebar" style="width: 250px; min-height: 100vh; position: fixed; background: linear-gradient(180deg, #ffffff 0%, #f8f9fa 100%); border-right: 1px solid #e9ecef;">
    <div class="p-3 text-center">
        <img src="{{ asset('images/logo.png') }}" alt="STIKOM BALI" class="img-fluid mb-3" style="max-width: 150px;">
        <h5 class="fw-bold text-primary">Dashboard CDC STIKOM Bali</h5>
    </div>
    
    <div class="nav flex-column p-2">
        <a href="{{ route('admin.alumni.index') }}" 
           class="nav-link py-2 mb-2 rounded {{ request()->routeIs('admin.alumni.*') ? 'active bg-primary text-white' : 'text-dark hover-link' }}"
           style="transition: all 0.3s ease;">
            <i class="bi bi-people me-2"></i> Kelola Alumni
        </a>
        
        <a href="{{ route('admin.reports') }}" 
           class="nav-link py-2 mb-2 rounded {{ request()->routeIs('admin.reports') ? 'active bg-primary text-white' : 'text-dark hover-link' }}"
           style="transition: all 0.3s ease;">
            <i class="bi bi-file-text me-2"></i> Laporan
        </a>
    </div>
</div>

<style>
.hover-link:hover {
    background-color: #e9ecef;
    color: #0d6efd !important;
    transform: translateX(5px);
}

.nav-link {
    border: 1px solid transparent;
}

.nav-link:hover {
    border-color: #dee2e6;
}

.active {
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
</style>