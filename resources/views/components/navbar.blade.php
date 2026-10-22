<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm py-2">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('user.index') }}">
            <i class="bi bi-mortarboard-fill text-warning fs-5"></i>
            <span>User<span class="text-info">Management</span></span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto gap-1">
                <li class="nav-item">
                    <a class="nav-link px-3 py-2 rounded {{ request()->is('user') ? 'active bg-secondary bg-opacity-50 text-white' : '' }}" href="{{ route('user.index') }}">
                        <i class="bi bi-people me-1"></i> Data User
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 py-2 rounded {{ request()->is('user/create') ? 'active bg-secondary bg-opacity-50 text-white' : '' }}" href="{{ route('user.create') }}">
                        <i class="bi bi-person-plus me-1"></i> Tambah User
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>