<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title','Admin')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="{{ asset('js/script.js') }}" defer></script>
</head>
<body>

<!-- Header admin -->
<header class="admin-header">
    <div class="brand">
        <a href="{{ route('admin.dashboard') }}">
          <img src="{{ asset('images/logo.png') }}" alt="ALBERT TTW" class="logo">
        </a>
    </div>

    <!-- Bouton burger pour mobile -->
    <button id="burger-btn" class="burger-btn" aria-label="Menu">&#9776;</button>

    <div class="logout">
        <form action="{{ route('admin.logout') }}" method="POST"> @csrf 
            <button type="submit">Déconnexion</button>
        </form>
    </div>
</header>

<!-- Overlay pour mobile -->
<div id="overlay" class="overlay"></div>

<div class="admin-container">
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <ul>
            <li class="{{ Route::is('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">Aperçu</a>
            </li>
            <li class="{{ Route::is('admin.products.*') ? 'active' : '' }}">
                <a href="{{ route('admin.products.index') }}">Produits</a>
            </li>
            <li class="{{ Route::is('admin.orders.*') ? 'active' : '' }}">
                <a href="{{ route('admin.orders.index') }}">Commandes</a>
            </li>
        </ul>
    </aside>

    <main class="content">
        @yield('content')
    </main>
</div>

<!-- Footer admin -->
<footer class="admin-footer">
    <div class="container">
        &copy; {{ date('Y') }} Administration ALBERT TTW. Tous droits réservés.
    </div>
</footer>

<script>
    const burgerBtn = document.getElementById('burger-btn');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');

    function openMenu() {
        sidebar.classList.add('show');
        overlay.classList.add('show');
    }

    function closeMenu() {
        sidebar.classList.remove('show');
        overlay.classList.remove('show');
    }

    burgerBtn.addEventListener('click', openMenu);
    overlay.addEventListener('click', closeMenu);

    // ferme le menu si on clique sur un lien du menu
    document.querySelectorAll('#sidebar a').forEach(link => {
        link.addEventListener('click', closeMenu);
    });
</script>

<style>
/* Base */
body { 
  margin:0;
  font-family: Arial, sans-serif; 
  background:#f5f5f5; 
  overflow-x: hidden;
}
.admin-header { 
  background:#333; 
  color:#fff; 
  display:flex; 
  justify-content:space-between; /* met tout ce qui reste à droite */ 
  align-items:center; 
  padding:10px 20px; 
  position:relative;
}

.admin-header .brand {
  position:absolute;
  left:50%;
  transform:translateX(-50%); /* centre horizontalement */
  text-align:center;
}

.admin-header .brand img.logo {
    height: 50px;       /* ajuste la taille du logo */
    width: auto;
}


.admin-header .logout{
  margin-left:auto;
}

.admin-header .logout button {
  background-color: #9e9e9eff;      /* rouge vif */
  color: #fff;
  border: none;
  padding: 6px 12px;
  border-radius: 4px;
  font-size: 14px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.admin-header .logout button:hover {
  background-color: #c0392b;      /* rouge un peu plus foncé au survol */
}

.admin-header a { 
  margin-top: 200px;
  color:#fff; 
  text-decoration:none; 
  font-weight:bold; }

.admin-container { 
  display:flex; 
  min-height:100vh; 
  width: 100%;
  box-sizing:border-box;
}

.sidebar { width:220px; background:#222; color:#fff; padding-top:20px; }
.sidebar ul { list-style:none; padding:0; margin:0; }
.sidebar li { margin:0; }
.sidebar a { display:block; color:#ccc; padding:10px 15px; text-decoration:none; }
.sidebar li.active a, .sidebar a:hover { background:#444; color:#fff; }
.content { flex:1; padding:20px; }
.cards { display:flex; gap:20px; flex-wrap:wrap; }
.card { background:#fff; padding:20px; flex:1; border-radius:4px; box-shadow:0 2px 4px rgba(0,0,0,0.1); }
.admin-footer { background: #2c3e50; color: #ecf0f1; text-align: center; padding: 10px 0; font-size: 14px; margin-top: 30px; }

/* Burger button */
.burger-btn { display:none; font-size:24px; background:none; border:none; color:#fff; cursor:pointer; }

/* Overlay */
.overlay {
    display:none;
    position:fixed;
    top:0; left:0;
    width:100%; height:100%;
    background:rgba(0,0,0,0.5);
    z-index:900;
}
.overlay.show { display:block; }

/* Responsive sidebar */
@media (max-width: 768px) {
    .sidebar { 
        position: fixed; 
        left: -250px; 
        top: 0; 
        height: 100%; 
        width: 220px; 
        transition: left 0.3s ease; 
        z-index: 1000; 
    }

    .admin-header {
      flex-direction: column;
      align-items: flex-start;
      flex-wrap:wrap;
      width: 100%;
    }

     .admin-header .logout {
      margin-right:0;
      margin-top: -25px;
     }

    .sidebar.show { left:0; }
    .burger-btn { display:block; }
    .admin-container { flex-direction: column; }
    .content { 
      padding:15px; 
      margin-left:0; 
      width: 100%;
    }

    .admin-footer {
      width: 100%;
    }
}
</style>

</body>
</html>
