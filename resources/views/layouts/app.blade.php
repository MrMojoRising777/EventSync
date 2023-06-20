<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'EventSync') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    @yield('styles')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{route('home')}}">
                    <img src="{{ asset('build/assets/images/logo.png') }}" alt="Logo" class="navbar-logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('home')}}">{{"Home"}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('friends')}}">{{"Friends"}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('event.create')}}">{{"Create event"}}</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{route('eventsPage')}}">{{"Events"}}</a>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('availabilities.index') }}">{{ "Availabilities" }}</a>
                        </li>




                    </ul>

                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->username }}
                                </a>

                                <!-- dashboard route -->
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ url('/profile') }}" onclick="event.preventDefault(); document.getElementById('userprofile-form').submit();">
                                        {{ __('Profile') }}
                                    </a>
                                    <form id="userprofile-form" action="{{ url('/profile') }}" method="GET" style="display: none;">
                                        @csrf
                                    </form>

                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>

        <footer class="footer bg-light">
            <div class="container py-4">
                <div class="row">
                    <div class="col text-center">
                        <p class="mb-1">&copy; {{ date('Y') }} EventSync. All rights reserved.</p>
                        <p class="mb-1">Thor Park 8300, 3600 Genk, Belgium</p>
                        <p class="mb-0">Email: info@sitenaam.com</p>
                    </div>
                </div>
            </div>
        </footer>


    </div>
</body>
</html>

<style>
    .navbar {
        position: relative;
        min-height: 6rem; /* Set a minimum height for the navbar */
    }

    .navbar-logo {
        position: absolute;
        transform: translate(-50%, -50%);
        height: 9rem; /* Increase the height to make the logo a little bigger */
        object-fit: contain;
    }

    .navbar-nav {
        margin-left: 10rem; /* Adjust the margin as desired to create space for the logo */
    }

    .navbar-nav .nav-link {
        line-height: 5rem; /* Adjust the line-height to match the logo height */
        padding: 1rem; /* Increase the padding as desired */
    }
</style>