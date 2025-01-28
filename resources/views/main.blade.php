<!doctype html>
<html lang="es" class="h-100" data-bs-theme="auto">

    <head>
        <!-- https://getbootstrap.com/docs/5.3/examples/sticky-footer/ -->

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
        <meta name="generator" content="Hugo 0.122.0">
        <meta name="theme-color" content="#712cf9">

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="url-base" content="{{ url('') }}">

        <title>Fetch</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <linl href="{{ url('assets/css/style.css') }}" rel="stylesheet">

        <style>
            .alert {
                display: none;
                opacity: 1;
                transition: opacity 0.5s ease;
            }
        </style>
    </head>

    <body class="d-flex flex-column h-100">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#registerModal">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="#" onclick="event.preventDefault();" data-url="{{ route('logout') }}" id="logoutButton">
                                        {{ __('Logout') }}
                                    </a>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <!-- modal -->
        @include('modal')

        <!-- page content -->
        <main class="flex-shrink-0">
            <div class="container">
                <h1 class="mt-5">Product</h1>
                <p class="lead">
                    Tercera versión de la misma aplicación de productos: fetch (ajax).
                </p>
                <div class="alert alert-success" role="alert" id="productSuccess">Successfully done.</div>
                <div class="alert alert-danger" role="alert" id="productError">Error doing.</div>
                <!-- dynamic content -->
                <div id="content"></div>
                <nav>
                    <!--dynamic pagination content -->
                    <ul class="pagination" id="pagination"></ul>
                </nav>
            </div>
        </main>

        <footer class="footer mt-auto py-3 bg-body-tertiary">
            <div class="container">
                <span class="text-body-secondary">Place sticky footer content here.</span>
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="{{ url('src/js/script.js') }}" type="module"></script>
    </body>
</html>