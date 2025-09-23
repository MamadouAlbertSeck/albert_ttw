@extends('layouts.app')

@section('title', 'Détails produit')

@section('content')
<h1 class="text-2xl font-bold mb-4">{{ $product->name }}</h1>

<div class="bg-white p-4 rounded shadow">
    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="mb-4 w-64">
    <p><strong>Prix :</strong> {{ number_format($product->price,2) }} CFA</p>
    <p><strong>Stock :</strong> {{ $product->stock_quantity }}</p>
    <p><strong>Description :</strong></p>
    <p>{{ $product->description }}</p>

    <div class="mt-4">
        <a href="{{ route('admin.products.edit', $product) }}" class="bg-blue-500 text-white px-3 py-1 rounded">Modifier</a>
        <a href="{{ route('admin.products.index') }}" class="text-gray-600 ml-2">Retour à la liste</a>
    </div>
</div>
@endsection
