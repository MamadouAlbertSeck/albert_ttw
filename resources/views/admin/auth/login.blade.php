@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded shadow mt-20">
    <h1 class="text-2xl font-bold mb-4 text-center">Connexion Admin</h1>

    <form method="POST" action="{{ route('admin.login') }}">
        @csrf
        <div class="mb-4">
            <label class="block mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="w-full border px-2 py-1 rounded">
            @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label class="block mb-1">Mot de passe</label>
            <input type="password" name="password" class="w-full border px-2 py-1 rounded">
            @error('password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <button type="submit" class="w-full bg-gray-900 text-white py-2 rounded hover:bg-gray-800">Se connecter</button>
    </form>
</div>
@endsection
