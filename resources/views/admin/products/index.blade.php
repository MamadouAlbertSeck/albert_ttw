@extends('layouts.app')

@section('title', 'Produits')

@section('content')
<div class="flex justify-between mb-4">
    <h1 class="text-xl font-bold">Produits</h1>
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
        @foreach($products as $product)
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

<div class="mt-4">
    {{ $products->links() }}
</div>
@endsection
