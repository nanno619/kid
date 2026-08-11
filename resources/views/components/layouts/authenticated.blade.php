@props(['title' => null])

@php
    $displayName = auth()->user()->short_name ?? auth()->user()->name;
    $initials = collect(explode(' ', $displayName))->map(fn ($word) => mb_substr($word, 0, 1))->join('');
    $initials = mb_strtoupper(mb_substr($initials, 0, 2));
@endphp

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
                        <span class="avatar avatar-sm">{{ $initials }}</span>
                        <div class="d-none d-xl-block ps-2">
                            <div>{{ $displayName }}</div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">Log out</button>
                        </form>
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
                        <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('dashboard') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="ti ti-home icon"></i></span>
                                <span class="nav-link-title">Dashboard</span>
                            </a>
                        </li>
                        @can('staff-profiles.edit-own')
                            <li class="nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('profile.edit') }}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="ti ti-user icon"></i></span>
                                    <span class="nav-link-title">My Profile</span>
                                </a>
                            </li>
                        @endcan
                        @can('staff-profiles.view')
                            <li class="nav-item {{ request()->routeIs('staff-profiles.*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('staff-profiles.index') }}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="ti ti-users icon"></i></span>
                                    <span class="nav-link-title">Staff Profiles</span>
                                </a>
                            </li>
                        @endcan
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
                        <h2 class="page-title">{{ $title }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-body">
            <div class="container-fluid">
                {{ $slot }}
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
