{{-- resources/views/products/show.blade.php --}}
@extends('layouts.app')

@section('title', $product->name)

@section('content')

@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 flex justify-between items-center">
    <span>{{ session('success') }}</span>
    <a href="{{ route('cart.index') }}" class="bg-green-700 text-white px-3 py-1 rounded hover:bg-green-800">Voir le panier</a>
</div>
@endif

<div class="max-w-4xl mx-auto">
  <div class="bg-white rounded shadow p-4">
    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="mb-4">
    <h1 class="text-2xl font-bold mb-2">{{ $product->name }}</h1>
    <p class="text-gray-700 mb-4">{{ $product->description }}</p>
    <p class="text-xl font-semibold mb-4">{{ number_format($product->price, 0, ',', ' ') }} CFA</p>

    <form action="{{ route('cart.add', $product->id) }}" method="POST">
      @csrf
      <button class="bg-gray-900 text-black px-4 py-2 rounded">Ajouter au panier</button>
    </form>
  </div>
</div>
@endsection
