{{-- resources/views/admin/auth/login.blade.php --}}

@extends('layouts.app')

@section('title', 'Login')

@section('content')

<div class="login-page">

    <!-- Formulaire transparent -->
    <div class="login-container">
        <h1 class="login-title">Admin Connexion </h1>

        <form method="POST" action="{{ route('admin.login') }}" class="login-form">
            @csrf

            <!-- Champ email -->
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Entrez votre email">
                @error('email')<p class="error">{{ $message }}</p>@enderror
            </div>

            <!-- Champ mot de passe -->
            <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" name="password" placeholder="••••••••">
                @error('password')<p class="error">{{ $message }}</p>@enderror
            </div>

            <!-- Bouton -->
            <button type="submit" class="btn-login">Se connecter</button>
        </form>
    </div>
</div>

@endsection

<style>


/* Zone de login avec logo derrière */
.login-page {
    position: fixed;
    top: 0;
    left:0;
    width: 100%;
    height:100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: url("{{ asset('images/logo.png') }}") no-repeat center center;
    background-size: 200px;
    background-color:gray;
}

/* Conteneur principal */
.login-container {
    width: 100%;
    max-width: 400px;
    padding: 32px;
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.2); /* transparence */
    backdrop-filter: blur(4px); /* flou derrière */
    text-align: center;
    box-shadow: 0 6px 20px rgba(0,0,0,0.3);
}

/* Titre */
.login-title {
    font-size: 1.6rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 24px;
}

/* Formulaire */
.login-form {
    text-align: left;
}

.form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 18px;
}

.form-group label {
    font-weight: 600;
    margin-bottom: 6px;
    color: #4a5568;
}

.form-group input {
    padding: 10px 12px;
    border: 1px solid #cbd5e0;
    border-radius: 6px;
    font-size: 14px;
    outline: none;
    transition: border 0.2s, box-shadow 0.2s;
}

.form-group input:focus {
    border-color: #3182ce;
    box-shadow: 0 0 0 2px rgba(49,130,206,0.2);
}

/* Erreurs */
.error {
    font-size: 0.85rem;
    color: #e53e3e;
    margin-top: 4px;
}

/* Bouton */
.btn-login {
    width: 100%;
    background: #2d3748;
    color: #fff;
    padding: 12px;
    font-weight: 600;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.3s;
}

.btn-login:hover {
    background: #1a202c;
}
</style>
