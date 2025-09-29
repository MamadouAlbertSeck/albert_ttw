@extends('layouts.admin')

@section('title', 'Détails produit')

@section('content')
{{-- --- Titre de la page --- --}}
<h1 class="product-title">{{ $product->name }}</h1>

{{-- --- Carte produit --- --}}
<div class="product-card">
    {{-- Image du produit --}}
    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">

    {{-- Infos principales --}}
    <div class="product-info">
        <p><strong>Prix :</strong> <span class="price">{{ number_format($product->price, 2, ',', ' ') }} CFA</span></p>
        <p><strong>Stock :</strong> <span class="stock">{{ $product->stock_quantity }}</span></p>
        <p><strong>Description :</strong></p>
        <p class="description">{{ $product->description }}</p>
    </div>

    {{-- Actions --}}
    <div class="product-actions">
        <a href="{{ route('admin.products.edit', $product) }}" class="btn edit-btn">Modifier</a>
        <a href="{{ route('admin.products.index') }}" class="btn back-btn">Retour à la liste</a>
    </div>
</div>
@endsection

{{-- --- CSS spécifique à cette page --- --}}
@push('styles')
<style>
/* --- Titre --- */
.product-title {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 20px;
    color: #2d3748;
}

/* --- Carte produit --- */
.product-card {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    max-width: 800px;
    margin: auto;
    display: flex;
    flex-direction: column;
    gap: 20px;
}

/* --- Image --- */
.product-image {
    width: 100%;
    max-width: 300px;
    border-radius: 6px;
    align-self: center;
}

/* --- Infos produit --- */
.product-info p {
    margin: 6px 0;
    font-size: 16px;
    color: #4a5568;
}

.product-info .price {
    font-weight: 700;
    color: #e53e3e;
}

.product-info .stock {
    font-weight: 600;
    color: #38a169;
}

/* --- Actions --- */
.product-actions {
    display: flex;
    gap: 10px;
    justify-content: flex-start;
}

.btn {
    padding: 8px 16px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

/* Bouton modifier */
.edit-btn {
    background-color: #3182ce;
    color: #fff;
}
.edit-btn:hover {
    background-color: #2b6cb0;
}

/* Bouton retour */
.back-btn {
    background-color: #edf2f7;
    color: #4a5568;
}
.back-btn:hover {
    background-color: #e2e8f0;
}

/* --- Responsive --- */
@media (max-width: 600px) {
    .product-card {
        padding: 15px;
    }

    .product-image {
        max-width: 100%;
    }
}
</style>
@endpush
