<x-layouts.app title="Dashboard">
    <div class="page">
        <header class="navbar navbar-expand-md d-print-none" data-bs-theme="dark">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
                    aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                    <a href="{{ route('dashboard') }}">{{ config('app.name', 'Laravel') }}</a>
                </h1>
                <div class="navbar-nav flex-row order-md-last">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex lh-1 p-0 px-2" data-bs-toggle="dropdown" aria-label="Open user menu">
                            <span class="avatar avatar-sm">GU</span>
                            <div class="d-none d-xl-block ps-2">
                                <div>Guest User</div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <a href="{{ route('login') }}" class="dropdown-item">Log out</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <header class="navbar-expand-md">
            <div class="collapse navbar-collapse" id="navbar-menu">
                <div class="navbar">
                    <div class="container-fluid">
                        <ul class="navbar-nav">
                            <li class="nav-item active">
                                <a class="nav-link" href="{{ route('dashboard') }}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="ti ti-home icon"></i></span>
                                    <span class="nav-link-title">Home</span>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#navbar-interface" data-bs-toggle="dropdown"
                                    data-bs-auto-close="outside" role="button" aria-expanded="false">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="ti ti-layout icon"></i></span>
                                    <span class="nav-link-title">Interface</span>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">Cards</a>
                                    <a class="dropdown-item" href="#">Tables</a>
                                    <a class="dropdown-item" href="#">Modals</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#navbar-forms" data-bs-toggle="dropdown"
                                    data-bs-auto-close="outside" role="button" aria-expanded="false">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="ti ti-checkbox icon"></i></span>
                                    <span class="nav-link-title">Forms</span>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">Form elements</a>
                                    <a class="dropdown-item" href="#">Form layouts</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
        <div class="page-wrapper">
            <div class="page-header d-print-none">
                <div class="container-fluid">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <h2 class="page-title">Dashboard</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-body">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">You're in</h3>
                            <p class="text-secondary mb-0">This is a prototype dashboard — reached after signing in.</p>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer footer-transparent d-print-none">
                <div class="container-fluid">
                    <div class="row text-center align-items-center justify-content-center">
                        <div class="col-12 col-lg-auto">
                            <ul class="list-inline list-inline-dots mb-0">
                                <li class="list-inline-item">&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</x-layouts.app>
