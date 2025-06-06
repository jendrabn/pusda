<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1"
          name="viewport">

    <!-- CSRF Token -->
    <meta content="{{ csrf_token() }}"
          name="csrf-token">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="//fonts.gstatic.com"
          rel="dns-prefetch">
    <link href="https://fonts.bunny.net/css?family=Nunito"
          rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand"
                   href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button aria-controls="navbarSupportedContent"
                        aria-expanded="false"
                        aria-label="{{ __('Toggle navigation') }}"
                        class="navbar-toggler"
                        data-bs-target="#navbarSupportedContent"
                        data-bs-toggle="collapse"
                        type="button">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="navbar-collapse collapse"
                     id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link"
                                       href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link"
                                       href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a aria-expanded="false"
                                   aria-haspopup="true"
                                   class="nav-link dropdown-toggle"
                                   data-bs-toggle="dropdown"
                                   href="#"
                                   id="navbarDropdown"
                                   role="button"
                                   v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div aria-labelledby="navbarDropdown"
                                     class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item"
                                       href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form action="{{ route('logout') }}"
                                          class="d-none"
                                          id="logout-form"
                                          method="POST">
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
    </div>
</body>

</html>
