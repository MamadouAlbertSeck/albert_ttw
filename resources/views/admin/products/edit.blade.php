{{-- resources/views/admin/products/edit.blade.php --}}

@extends('layouts.admin')

@section('title', 'Modifier Produit')

@section('content')

<div class="page-header">
    <h1 class="page-title">Modifier Produit</h1>
</div>

<form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="form-container">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label>Nom</label>
        <input type="text" name="name" value="{{ old('name', $product->name) }}" placeholder="Nom du produit">
    </div>

    <div class="form-group">
        <label>Slug</label>
        <input type="text" name="slug" value="{{ old('slug', $product->slug) }}" placeholder="slug-unique">
    </div>

    <div class="form-group">
        <label>Description</label>
        <textarea name="description" placeholder="Description du produit">{{ old('description', $product->description) }}</textarea>
    </div>

    <div class="form-group">
        <label>Prix (CFA)</label>
        <input type="number" name="price" step="0.01" value="{{ old('price', $product->price) }}" placeholder="Prix du produit">
    </div>

    <div class="form-group">
        <label>Stock</label>
        <input type="number" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" placeholder="Quantité en stock">
    </div>

    <div class="form-group">
        <label>Image</label>
        <input type="file" name="image">
        @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="preview-img">
        @endif
    </div>

    <button type="submit" class="btn submit-btn">Mettre à jour</button>
</form>

@endsection

<style>
/* Conteneur du formulaire */
.form-container {
    background: #fff;
    padding: 24px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    max-width: 700px;
    margin-top: 20px;
}

/* Champs du formulaire */
.form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 16px;
}

.form-group label {
    font-weight: 600;
    margin-bottom: 6px;
    color: #2d3748;
}

.form-group input,
.form-group textarea {
    padding: 10px 12px;
    border-radius: 6px;
    border: 1px solid #cbd5e0;
    font-size: 14px;
    outline: none;
    transition: border 0.2s ease, box-shadow 0.2s ease;
}

.form-group input:focus,
.form-group textarea:focus {
    border-color: #3182ce;
    box-shadow: 0 0 0 2px rgba(49,130,206,0.2);
}

/* Aperçu de l’image */
.preview-img {
    margin-top: 10px;
    border-radius: 6px;
    border: 1px solid #e2e8f0;
    width: 120px;
}

/* Bouton */
.btn.submit-btn {
    background-color: #3182ce;
    color: #fff;
    font-weight: 600;
    padding: 10px 20px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    transition: background 0.3s ease;
}

.btn.submit-btn:hover {
    background-color: #2b6cb0;
}

/* Responsive */
@media (max-width: 600px) {
    .form-container {
        padding: 16px;
    }
    .preview-img {
        width: 100px;
    }
}
</style>
