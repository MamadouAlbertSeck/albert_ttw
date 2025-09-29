@extends('layouts.admin')

@section('title', 'Créer Produit')

@section('content')

<div class="page-header">
    <h1 class="page-title">Créer Produit</h1>
</div>

<form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="form-container">
    @csrf

    <div class="form-group">
        <label>Nom</label>
        <input type="text" name="name" value="{{ old('name') }}" placeholder="Nom du produit">
    </div>

    <div class="form-group">
        <label>Slug</label>
        <input type="text" name="slug" value="{{ old('slug') }}" placeholder="slug-unique">
    </div>

    <div class="form-group">
        <label>Description</label>
        <textarea name="description" placeholder="Description du produit">{{ old('description') }}</textarea>
    </div>

    <div class="form-group">
        <label>Prix (CFA)</label>
        <input type="number" name="price" step="0.01" value="{{ old('price') }}" placeholder="Prix du produit">
    </div>

    <div class="form-group">
        <label>Stock</label>
        <input type="number" name="stock_quantity" value="{{ old('stock_quantity') }}" placeholder="Quantité en stock">
    </div>

    <div class="form-group">
        <label>Image</label>
        <input type="file" name="image">
    </div>

    <button type="submit" class="btn submit-btn">Enregistrer</button>
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

/* Bouton d'enregistrement */
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
}
</style>
