<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @if (View::hasSection('title'))
            @yield('title')
        @else
            Online könyvtár
        @endif
    </title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fontawesome.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
            @auth
            @if (Auth::user()->is_librarian)
                 <nav class="navbar navbar-expand-lg navbar-light bg-primary">
            @else
                 <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            @endif
            @endauth
            @guest
               <nav class="navbar navbar-expand-lg navbar-light bg-light">
            @endguest

            <div class="container">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <a class="navbar-brand disabled" href="{{ url('/') }}">Könyvtár</a>
                    <ul class="navbar-nav mr-auto">

                    @auth
                    @if (Auth::user()->is_librarian)
                        <li class="nav-link disabled">Könyvtáros felület</li>
                    @else
                        <li class="nav-link disabled">Olvasó felület</li>
                    @endif
                    @endauth

                    @guest
                       <li class="nav-link disabled">Vendég felület</li>
                    @endguest


                    <li class="nav-item">
                        <a class="nav-link navbar-brand {{ Route::currentRouteNamed('books.index') ? 'active' : '' }}" href="{{ url('/') }}">Könyvek</a>
                        @auth
                        @if (Auth::user()->is_librarian)
                            <a class="nav-link navbar-brand {{ Route::currentRouteNamed('borrows.index') ? 'active' : '' }}" href="{{ route('borrows.index') }}">Kölcsönzések kezelése</a>
                        @else
                            <a class="nav-link navbar-brand {{ Route::currentRouteNamed('borrows.index') ? 'active' : '' }}" href="{{  route('borrows.index') }}">Kölcsönzéseim</a>
                        @endif
                        @endauth
                    </li>

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
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
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('profile.index') }}">Profil</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
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

        <footer>
            <div class="container mb-4">
                <hr>
                <div class="d-flex flex-column align-items-center">
                    <div>
                        <span class="small">Nagy Gergő - CS4LP6</span>
                        <span class="mx-1">·</span>
                        <span class="small">Laravel {{ app()->version() }}</span>
                        <span class="mx-1">·</span>
                        <span class="small">PHP {{ phpversion() }}</span>
                    </div>

                    <div>
                        <span class="small">Szerveroldali webprogramozás beadandó 2020-21-2</span>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
