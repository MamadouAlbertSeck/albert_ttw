<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title','ALBERT TTW')</title>
        <link rel="stylesheet" href="{{ asset('css/style.css')}}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body >
        <header id="site-header" class="site-header">
            <div class="container">
                <a href="{{ route('home') }}" class="brand">ALBERT TTW</a>
                <nav> <!-- mini panier / liens --> </nav>
            </div>
        </header>

        <main class="container">
            @yield('content')
        </main>

        <script src="{{ asset('js/script.js') }}"></script>
    </body>
</html>
