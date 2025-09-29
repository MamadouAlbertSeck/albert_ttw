@extends('layouts.admin')

@section('title', 'Produits')

@section('content')
{{-- --- Entête de la page avec bouton Ajouter --- --}}
<div class="page-header">
    <h1 class="page-title">Produits</h1>
    <a href="{{ route('admin.products.create') }}" class="btn add-btn">Ajouter Produit</a>
</div>

{{-- --- Tableau produits --- --}}
<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prix</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ number_format($product->price, 2, ',', ' ') }} CFA</td>
                <td>{{ $product->stock_quantity }}</td>
                <td class="actions">
                    <a href="{{ route('admin.products.edit', $product) }}" class="btn edit-btn">Modifier</a>
                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Supprimer ce produit ?');" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn danger-btn">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@push('styles')
<style>
.page-header {
    display: flex;
    justify-content: space-between; /* titre à gauche,bouton à droite */
    align-items: center;
    margin-bottom: 20px;
    flex-wrap: wrap; /* pour mobile, bouton descendra si écran trop petit */
}

/* --- Titre page --- */
.page-title {
    font-size: 28px;
    font-weight: 700;
    color: #2d3748;
}

/* --- Bouton Ajouter --- */
.btn {
    padding: 8px 16px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.add-btn {
    background-color: #3182ce;
    color: #fff;
}
.add-btn:hover {
    background-color: #2b6cb0;
}

/* --- Tableau --- */
.table-container {
    overflow-x: auto; /* scroll horizontal si besoin */
}

.table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    overflow: hidden;
}

.table th, .table td {
    padding: 12px 10px;
    text-align: left;
    border-bottom: 1px solid #eee;
}

.table th {
    background-color: #f7fafc;
    font-weight: 600;
    color: #4a5568;
}

/* --- Actions --- */
.actions a, .actions button {
    margin-right: 6px;
    padding: 6px 10px;
    border-radius: 5px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s ease;
}

/* Modifier */
.edit-btn {
    background-color: #38a169;
    color: #fff;
}
.edit-btn:hover {
    background-color: #2f855a;
}

/* Supprimer */
.danger-btn {
    background-color: #e53e3e;
    color: #fff;
    border: none;
}
.danger-btn:hover {
    background-color: #c53030;
}

/* --- Responsive --- */
@media (max-width: 768px) {
    .table th, .table td {
        padding: 10px 8px;
        font-size: 14px;
    }

    .btn {
        padding: 6px 12px;
        font-size: 14px;
    }
}
</style>
@endpush
