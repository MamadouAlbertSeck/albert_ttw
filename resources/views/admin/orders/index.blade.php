@extends('layouts.admin')

@section('title', 'Commandes')

@section('content')

{{-- --- Titre de la page --- --}}
<h1 class="page-title">Commandes</h1>

{{-- --- Container scrollable pour mobile --- --}}
<div class="table-container">
    {{-- --- Tableau principal des commandes --- --}}
    <table class="orders-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Total</th>
                <th>Statut</th>
                <th>Produits</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                {{-- --- Colonne ID de la commande --- --}}
                <td>{{ $order->id }}</td>

                {{-- --- Nom du client ou email si absent --- --}}
                <td>{{ $order->customer_name ?? $order->email }}</td>

                {{-- --- Montant total formaté --- --}}
                <td>{{ number_format($order->total_amount, 2, ',', ' ') }} CFA</td>

                {{-- --- Statut avec formulaire de mise à jour --- --}}
                <td>
                    <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}">
                        @csrf
                        @method('PATCH')

                        {{-- --- Select avec couleurs selon le statut --- --}}
                        <select name="status" onchange="this.form.submit()" class="status-select {{ $order->status }}">
                            <option value="pending" @if($order->status=='pending') selected @endif>Pending</option>
                            <option value="paid" @if($order->status=='paid') selected @endif>Paid</option>
                            <option value="shipped" @if($order->status=='shipped') selected @endif>Shipped</option>
                            <option value="cancelled" @if($order->status=='cancelled') selected @endif>Cancelled</option>
                        </select>
                    </form>
                </td>

                {{-- --- Liste des produits commandés --- --}}
                <td>
                    <ul class="product-list">
                        @foreach($order->items as $item)
                        <li>{{ $item->product->name }} x {{ $item->quantity }}</li>
                        @endforeach
                    </ul>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@push('styles')
<style>
/* --- Style du titre de page --- */
.page-title {
    font-size: 26px;
    font-weight: 700;
    margin-bottom: 20px;
    color: #2d3748;
}

/* --- Container scrollable pour mobile --- */
.table-container {
    overflow-x: auto;
}

/* --- Tableau principal --- */
.orders-table {
    width: 100%;
    border-collapse: separate; /* pour permettre border-radius */
    border-spacing: 0;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.08); /* légère ombre */
    font-family: 'Arial', sans-serif;
}

/* --- En-tête du tableau --- */
.orders-table thead {
    background-color: #f1f5f9;
    font-weight: 600;
    color: #2d3748;
}

/* --- Cellules du tableau --- */
.orders-table th, .orders-table td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #e2e8f0;
}

/* --- Effet au survol des lignes --- */
.orders-table tbody tr:hover {
    background-color: #f9fafb;
}

/* --- Select de statut --- */
.status-select {
    padding: 5px 10px;
    border-radius: 4px;
    border: 1px solid #cbd5e0;
    background-color: #fff;
    cursor: pointer;
    transition: 0.3s;
    font-weight: 600;
    color: #2d3748;
}

/* --- Couleurs des statuts --- */
.status-select.pending { background-color: #fcd34d; color: #000; }
.status-select.paid { background-color: #34d399; color: #000; }
.status-select.shipped { background-color: #60a5fa; color: #fff; }
.status-select.cancelled { background-color: #f87171; color: #fff; }

/* --- Liste des produits --- */
.product-list {
    padding-left: 16px;
    margin: 0;
}

.product-list li {
    font-size: 14px;
    color: #4a5568;
}

/* --- Responsive : ajustements sur petits écrans --- */
@media (max-width: 768px) {
    .orders-table th, .orders-table td {
        padding: 8px 10px;
        font-size: 13px;
    }
    .page-title {
        font-size: 20px;
    }
}
</style>
@endpush
