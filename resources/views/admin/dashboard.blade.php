@extends('layouts.admin')

@section('title', 'Tableau de bord')

@section('content')

{{-- --- Entête de la page --- --}}
<h1>Tableau de bord</h1>

{{-- --- Rangée de cartes statistiques --- --}}
<div class="dashboard-cards">
    {{-- Nombre total de produits --}}
    <div class="card">
        {{-- titre --}}
        <h3>Produits</h3>
        {{-- valeur --}}
        <p class="big">{{ $totalProducts }}</p>
        {{-- petite description --}}
        <p class="muted">Articles en base</p>
    </div>

    {{-- Nombre total de commandes --}}
    <div class="card">
        <h3>Commandes</h3>
        <p class="big">{{ $totalOrders }}</p>
        <p class="muted">Commandes reçues</p>
    </div>

    {{-- Chiffre d'affaires total --}}
    <div class="card">
        <h3>CA total</h3>
        <p class="text-3xl">{{ number_format($totalRevenue, 2, ',', ' ') }} CFA</p>

        <p class="muted">Depuis le début</p>
    </div>

    {{-- Optionnel : visiteurs --}}
    {{-- <div class="card">
        <h3>Visiteurs</h3>
        <p class="big">{{ $totalVisitors }}</p>
        <p class="muted">Visiteurs totaux</p>
    </div> --}}
</div>

{{-- --- Section graphique mensuel --- --}}
<div class="card full-width">
    <h3>Ventes mensuelles</h3>
    {{-- canvas pour Chart.js (ou autre) --}}
    <canvas id="monthlyChart" width="400" height="120"></canvas>
</div>

{{-- --- Produits récents (aperçu + actions rapides) --- --}}
<div class="card">
    <div class="card-header">
        <h3>Produits récents</h3>
        <a href="{{ route('admin.products.create') }}" class="btn">Ajouter</a>
    </div>

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
            @foreach($recentProducts as $product)
            <tr>
                {{-- lien vers la fiche produit admin --}}
                <td>{{ $product->id }}</td>
                <td><a href="{{ route('admin.products.show', $product) }}">{{ $product->name }}</a></td>
                <td>{{ number_format($product->price,0,',',' ') }} CFA</td>
                <td>{{ $product->stock_quantity ?? 0 }}</td>
                <td class="actions">
                    <a class="btn small" href="{{ route('admin.products.show', $product) }}">Voir</a>
                    <a class="btn small" href="{{ route('admin.products.edit', $product) }}">Edit</a>

                    {{-- suppression : formulaire POST + method DELETE --}}
                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Supprimer ce produit ?');" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn danger small" type="submit">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="text-right">
        <a href="{{ route('admin.products.index') }}">Voir tous les produits →</a>
    </div>
</div>

{{-- --- Commandes récentes (aperçu) --- --}}
<div class="card">
    <div class="card-header">
        <h3>Commandes récentes</h3>
        <a href="{{ route('admin.orders.index') }}" class="btn">Voir toutes</a>
    </div>

    <table class="table small">
        <thead>
            <tr>
                <th>#</th>
                <th>Client</th>
                <th>Total</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentOrders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->customer_name ?? $order->email }}</td>
                <td>{{ number_format($order->total_amount,0,',',' ') }} CFA</td>
                <td>{{ $order->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

{{-- ----- Scripts spécifiques au dashboard ----- --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Préparer les données pour Chart.js
    const monthlyData = @json($monthlySales->pluck('total')->toArray());
    const monthlyLabels = @json($monthlySales->pluck('month')->map(function($m){ return "M".$m; })->toArray());

    const ctx = document.getElementById('monthlyChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: monthlyLabels,
                datasets: [{
                    label: 'Ventes (CFA)',
                    data: monthlyData,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }
</script>
@endpush

<style>
   /* cartes / layout */
.dashboard-cards { display:flex; gap:16px; flex-wrap:wrap; margin-bottom:16px; }
.card { background:#fff; padding:16px; border-radius:6px; box-shadow:0 2px 6px rgba(0,0,0,0.06); }
.card.full-width { width:100%; height:220px; }
.card .big { font-size:28px; font-weight:700; margin:8px 0; }
.card .muted { color:#666; font-size:13px; }

/* table */
.table { width:100%; border-collapse:collapse; margin-top:8px; }
.table th, .table td { padding:8px 10px; border-bottom:1px solid #eee; text-align:left; }
.table small { color:#666; }

/* actions & buttons */
.btn { background:#2d3748; color:#fff; padding:6px 10px; border-radius:4px; text-decoration:none; display:inline-block; }
.btn.small { padding:4px 8px; font-size:13px; }
.btn.danger { background:#e53e3e; }
.actions form { display:inline; }

/* responsive */
@media (max-width:900px) {
    .dashboard-cards { flex-direction:column; }
}
 
</style>