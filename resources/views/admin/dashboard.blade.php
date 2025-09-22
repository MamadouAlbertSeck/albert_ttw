@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<h1 class="text-2xl font-bold mb-6">Dashboard</h1>

<!-- Statistiques -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white p-4 rounded shadow">
        <h2 class="font-bold mb-2">Produits</h2>
        <p class="text-3xl">{{ \App\Models\Product::count() }}</p>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <h2 class="font-bold mb-2">Commandes</h2>
        <p class="text-3xl">{{ \App\Models\Order::count() }}</p>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <h2 class="font-bold mb-2">CA total</h2>
        <p class="text-3xl">{{ number_format(\App\Models\Order::sum('total_amount'),2) }} CFA</p>
    </div>
</div>

<!-- Produits récents / Gestion rapide -->
<div class="bg-white p-4 rounded shadow">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold">Produits récents</h2>
        <a href="{{ route('admin.products.create') }}" class="bg-gray-900 text-white px-3 py-1 rounded">Ajouter Produit</a>
    </div>

    <table class="w-full bg-white rounded shadow">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-2">ID</th>
                <th class="p-2">Nom</th>
                <th class="p-2">Prix</th>
                <th class="p-2">Stock</th>
                <th class="p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach(\App\Models\Product::latest()->take(5)->get() as $product)
            <tr class="border-t">
                <td class="p-2">{{ $product->id }}</td>
                <td class="p-2">{{ $product->name }}</td>
                <td class="p-2">{{ number_format($product->price,2) }}</td>
                <td class="p-2">{{ $product->stock_quantity }}</td>
                <td class="p-2 flex gap-2">
                    <a href="{{ route('admin.products.edit', $product) }}" class="bg-blue-500 text-white px-2 py-1 rounded">Edit</a>
                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Supprimer ce produit ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-2 text-right">
        <a href="{{ route('admin.products.index') }}" class="text-blue-600 hover:underline">Voir tous les produits</a>
    </div>
</div>

@endsection
