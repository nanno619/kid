<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        @fonts

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="page page-center">
            <div class="container container-normal py-4">
                <div class="row align-items-center g-4">
                    <div class="col-lg">
                        <div class="container-tight">
                            @if (Route::has('login'))
                                <div class="d-flex justify-content-end gap-2 mb-4">
                                    @auth
                                        <a href="{{ url('/dashboard') }}" class="btn btn-outline-secondary">Dashboard</a>
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-outline-secondary">Log in</a>

                                        @if (Route::has('register'))
                                            <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                                        @endif
                                    @endauth
                                </div>
                            @endif

                            <div class="card card-md">
                                <div class="card-body">
                                    <h1 class="h2 mb-2">Let's get started</h1>
                                    <p class="text-secondary mb-4">With so many options available to you, we suggest you start with the following:</p>

                                    <div class="list-group list-group-flush mb-4">
                                        <div class="list-group-item px-0">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <span class="status-dot status-dot-animated bg-red d-block"></span>
                                                </div>
                                                <div class="col text-truncate">
                                                    Read the
                                                    <a href="https://laravel.com/docs" target="_blank" class="ms-1">
                                                        Documentation <i class="ti ti-external-link icon icon-sm"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-group-item px-0">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <span class="status-dot bg-red d-block"></span>
                                                </div>
                                                <div class="col text-truncate">
                                                    Watch video tutorials at
                                                    <a href="https://laracasts.com" target="_blank" class="ms-1">
                                                        Laracasts <i class="ti ti-external-link icon icon-sm"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="btn-list mb-4">
                                        <a href="https://cloud.laravel.com" target="_blank" class="btn btn-dark">
                                            Deploy now
                                        </a>
                                    </div>

                                    <p class="text-secondary mb-0">
                                        v{{ app()->version() }}
                                        <a href="https://github.com/laravel/framework/blob/13.x/CHANGELOG.md" target="_blank" class="ms-1">
                                            View changelog <i class="ti ti-external-link icon icon-sm"></i>
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
