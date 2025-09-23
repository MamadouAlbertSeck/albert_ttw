<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title','ALBERT TTW')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="{{ asset('js/script.js') }}" defer></script>
</head>
<body>
    <!-- Header -->
    <header class="site-header">
        <div class="container">
            <a href="{{ route('home') }}" class="brand">ALBERT TTW</a>
            <nav class="main-nav">
                <a href="{{ route('home') }}">Produits</a>
                <a href="{{ route('cart.index') }}">Panier
                    @if(session('cart'))
                        ({{ count(session('cart')) }})
                    @endif
                </a>
            </nav>
        </div>
    </header>

    <!-- Flash message -->
    @if(session('success'))
    <div class="flash-success">
        {{ session('success') }}
        <a href="{{ route('cart.index') }}" class="flash-link">Voir le panier</a>
    </div>
    @endif

    <!-- Main content -->
    <main class="container">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="container footer-content">
            <div class="footer-col">
                <h3>ALBERT TTW</h3>
                <p>Marque de streetwear sénégalaise. Qualité et style pour tous.</p>
            </div>
            <div class="footer-col">
                <h3>Liens utiles</h3>
                <ul>
                    <li><a href="{{ route('home') }}">Produits</a></li>
                    <li><a href="{{ route('cart.index') }}">Panier</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h3>Réseaux sociaux</h3>
                <ul class="social-links">
                    <li><a href="#">Facebook</a></li>
                    <li><a href="#">Instagram</a></li>
                    <li><a href="#">Twitter</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; {{ date('Y') }} ALBERT TTW. Tous droits réservés.
        </div>
    </footer>
</body>

<style>

body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background: #f5f5f5;
}

.container {
    width: 90%;
    max-width: 1200px;
    margin: 0 auto;
}

/* Header */
.site-header {
    background: #fff;
    padding: 15px 0;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.site-header .brand {
    font-size: 24px;
    font-weight: bold;
    text-decoration: none;
    color: #333;
}

.main-nav {
    margin-top: 10px;
}

.main-nav a {
    margin-right: 20px;
    text-decoration: none;
    color: #333;
}

.main-nav a:hover {
    color: #000;
}

/* Flash message */
.flash-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
    padding: 10px;
    margin: 10px auto;
    text-align: center;
}

.flash-success .flash-link {
    margin-left: 20px;
    color: #155724;
    text-decoration: underline;
}

/* Main */
main.container {
    padding: 20px 0;
}

/* Footer */
.site-footer {
    background: #333;
    color: #fff;
    padding: 30px 0 10px 0;
    font-size: 14px;
}

.site-footer h3 {
    margin-top: 0;
}

.site-footer a {
    color: #fff;
    text-decoration: none;
}

.site-footer a:hover {
    text-decoration: underline;
}

.footer-content {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}

.footer-col {
    flex: 1;
    margin-bottom: 20px;
}

.footer-col ul {
    list-style: none;
    padding: 0;
}

.footer-col ul li {
    margin-bottom: 5px;
}

.footer-bottom {
    text-align: center;
    border-top: 1px solid #444;
    padding: 10px 0;
    margin-top: 20px;
}

/* Responsive */
@media (max-width: 768px) {
    .footer-content {
        flex-direction: column;
    }
    .main-nav {
        text-align: center;
        margin-top: 10px;
    }
    .main-nav a {
        display: block;
        margin: 5px 0;
    }
}


</style>

</html>

