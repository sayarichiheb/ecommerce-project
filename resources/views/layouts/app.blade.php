<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('products.index') }}">🛒 E-Commerce</a>
<div class="navbar-nav ms-auto">
    @auth
        <a class="nav-link" href="{{ route('cart.index') }}">🛒 Panier</a>
        <a class="nav-link" href="{{ route('orders.index') }}">📦 Commandes</a>
        <a class="nav-link" href="{{ route('products.create') }}">➕ Ajouter</a>
        <a class="nav-link" href="{{ route('profile') }}">👤 Profil</a>
        @if(auth()->user()->role === 'admin')
            <a class="nav-link text-warning" href="{{ route('admin.dashboard') }}">🛠️ Admin</a>
        @endif
        <span class="nav-link text-muted">{{ Auth::user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}" class="d-inline">
            @csrf
            <button class="btn btn-outline-light btn-sm ms-2">Déconnexion</button>
        </form>
    @else
        <a class="nav-link" href="{{ route('login') }}">Connexion</a>
        <a class="nav-link" href="{{ route('register') }}">Inscription</a>
    @endauth
</div>
    </div>
</nav>

<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>