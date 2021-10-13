<!DOCTYPE html>
<html lang="{{ App::currentLocale() }}" dir="{{ App::currentLocale() == 'ar'? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @if (App::currentLocale() == 'ar')
    <link rel="stylesheet" href="{{ asset('css/bootstrap.rtl.min.css') }}">
    @else
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    @endif
    <link rel="stylesheet" href="{{ asset('css/headers.css') }}">
    <title>{{ config('app.name') }}</title>
    @stack('styles')
</head>

<body>
    <header class="p-3 mb-3 border-bottom">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
                    <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap">
                        <use xlink:href="#bootstrap" />
                    </svg>
                </a>

                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="#" class="nav-link px-2 link-secondary">Overview</a></li>
                    <li><a href="#" class="nav-link px-2 link-dark">Inventory</a></li>
                    <li><a href="#" class="nav-link px-2 link-dark">Customers</a></li>
                    <li><a href="#" class="nav-link px-2 link-dark">Products</a></li>
                </ul>

                <form method="get" action="{{ route('questions.index') }}" class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
                    <input type="search" name="search" class="form-control" placeholder="Search..." aria-label="Search">
                </form>

                <div class="me-2 dropdown text-end">
                    <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="locale" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ LaravelLocalization::getCurrentLocaleNative() }}
                    </a>
                    <ul class="dropdown-menu text-small" aria-labelledby="locale">
                        @foreach(LaravelLocalization::getSupportedLocales() as $code => $locale)
                        <li><a class="dropdown-item" href="{{ LaravelLocalization::getLocalizedURL($code) }}">{{ $locale['native'] }}</a></li>
                        @endforeach
                    </ul>

                </div>

                @auth
                <x-notifications-menu />

                <div class="ms-2 dropdown text-end">
                    <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ Auth::user()->photo_url }}" width="32" height="32" class="rounded-circle">
                    </a>
                    <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
                        <li><a class="dropdown-item" href="{{ route('profile') }}">Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" onclick="document.getElementById('logout').submit()" href="javascript:;">Sign out</a></li>
                        <form action="{{ route('logout') }}" method="post" id="logout" style="display: none;">
                            @csrf
                        </form>
                    </ul>
                </div>
                @else
                <a href="{{ route('login') }}">{{ __('Login') }}</a>
                @endauth
            </div>
        </div>
    </header>
    <div class="container">
        <header class="mb-4 bg-light">
            <h2>@yield('title', 'Page Title')</h2>
            <hr>
        </header>

        @yield('content')
    </div>

    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="notifcationToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <img src="" class="rounded me-2" alt="...">
                <strong class="me-auto" id="notifcation-title"></strong>
                <small id="notifcation-time"></small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="notifcation-body">
            </div>
        </div>
    </div>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script>
        const userId = "{{ Auth::id() }}";
    </script>
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
</body>

</html>