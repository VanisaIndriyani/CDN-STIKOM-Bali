<!-- In your navbar -->
<ul class="navbar-nav ms-auto">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle fs-5 me-2"></i>
            {{ Auth::user()->name }}
        </a>
        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="profileDropdown">
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item">
                        <i class="bi bi-box-arrow-right me-2"></i>
                        Logout
                    </button>
                </form>
            </li>
        </ul>
    </li>
</ul>