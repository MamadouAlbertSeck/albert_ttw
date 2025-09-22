@extends('layouts.app')

@section('title', 'Créer Produit')

@section('content')
<h1 class="text-xl font-bold mb-4">Créer Produit</h1>

<form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="bg-white p-4 rounded shadow">
    @csrf
    <div class="mb-4">
        <label class="block mb-1">Nom</label>
        <input type="text" name="name" class="w-full border px-2 py-1 rounded" value="{{ old('name') }}">
    </div>
    <div class="mb-4">
        <label class="block mb-1">Slug</label>
        <input type="text" name="slug" class="w-full border px-2 py-1 rounded" value="{{ old('slug') }}">
    </div>
    <div class="mb-4">
        <label class="block mb-1">Description</label>
        <textarea name="description" class="w-full border px-2 py-1 rounded">{{ old('description') }}</textarea>
    </div>
    <div class="mb-4">
        <label class="block mb-1">Prix</label>
        <input type="number" name="price" step="0.01" class="w-full border px-2 py-1 rounded" value="{{ old('price') }}">
    </div>
    <div class="mb-4">
        <label class="block mb-1">Stock</label>
        <input type="number" name="stock_quantity" class="w-full border px-2 py-1 rounded" value="{{ old('stock_quantity') }}">
    </div>
    <div class="mb-4">
        <label class="block mb-1">Image</label>
        <input type="file" name="image" class="w-full border px-2 py-1 rounded">
    </div>

    <button type="submit" class="bg-gray-900 text-white px-4 py-2 rounded">Enregistrer</button>
</form>
@endsection
