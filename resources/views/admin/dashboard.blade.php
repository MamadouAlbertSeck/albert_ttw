@extends('layouts.admin')

@section('title', 'Tableau de bord')

@section('content')

{{-- --- Entête de la page --- --}}
<div class="page-header">
    <h1>Tableau de bord</h1>
    <p class="subtitle">Aperçu de votre activité commerciale</p>
</div>

{{-- --- Rangée de cartes statistiques --- --}}
<div class="dashboard-cards">
    {{-- Nombre total de produits --}}
    <div class="stat-card">
        <div class="stat-icon product">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m7.5 4.27 9 5.15"></path>
                <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"></path>
                <path d="m3.3 7 8.7 5 8.7-5"></path>
                <path d="M12 22V12"></path>
            </svg>
        </div>
        <div class="stat-content">
            <h3>Produits</h3>
            <p class="big">{{ $totalProducts }}</p>
            <p class="muted">Articles en base</p>
        </div>
    </div>

    {{-- Nombre total de commandes --}}
    <div class="stat-card">
        <div class="stat-icon order">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path>
                <path d="M3 6h18"></path>
                <path d="M16 10a4 4 0 0 1-8 0"></path>
            </svg>
        </div>
        <div class="stat-content">
            <h3>Commandes</h3>
            <p class="big">{{ $totalOrders }}</p>
            <p class="muted">Commandes reçues</p>
        </div>
    </div>

    {{-- Chiffre d'affaires total --}}
    <div class="stat-card">
        <div class="stat-icon revenue">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="1" x2="12" y2="23"></line>
                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
            </svg>
        </div>
        <div class="stat-content">
            <h3>CA total</h3>
            <p class="big">{{ number_format($totalRevenue, 0, ',', ' ') }} CFA</p>
            <p class="muted">Depuis le début</p>
        </div>
    </div>

    {{-- Clients actifs --}}
    <div class="stat-card">
        <div class="stat-icon customer">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
        </div>
        <div class="stat-content">
            <h3>Clients</h3>
            <p class="big">{{ $totalCustomers ?? 156 }}</p>
            <p class="muted">Clients actifs</p>
        </div>
    </div>
</div>

{{-- --- Section graphique mensuel --- --}}
<div class="dashboard-section">
    <div class="section-header">
        <h3>Ventes mensuelles</h3>
        <div class="section-actions">
            <select id="chartPeriod" class="select">
                <option value="6">6 derniers mois</option>
                <option value="12" selected>12 derniers mois</option>
                <option value="24">24 derniers mois</option>
            </select>
        </div>
    </div>
    <div class="chart-container">
        <canvas id="monthlyChart" width="400" height="120"></canvas>
    </div>
</div>

<div class="dashboard-grid">
    {{-- --- Produits récents (aperçu + actions rapides) --- --}}
    <div class="dashboard-section">
        <div class="section-header">
            <h3>Produits récents</h3>
            <div class="section-actions">
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 5v14"></path>
                        <path d="M5 12h14"></path>
                    </svg>
                    Ajouter
                </a>
            </div>
        </div>

        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prix</th>
                        <th>Stock</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentProducts as $product)
                    <tr>
                        {{-- lien vers la fiche produit admin --}}
                        <td class="id">{{ $product->id }}</td>
                        <td class="name"><a href="{{ route('admin.products.show', $product) }}">{{ $product->name }}</a></td>
                        <td class="price">{{ number_format($product->price,0,',',' ') }} CFA</td>
                        <td class="stock">
                            <span class="stock-badge {{ $product->stock_quantity > 10 ? 'in-stock' : ($product->stock_quantity > 0 ? 'low-stock' : 'out-of-stock') }}">
                                {{ $product->stock_quantity ?? 0 }}
                            </span>
                        </td>
                        <td class="actions">
                            <div class="action-buttons">
                                <a class="btn btn-icon" href="{{ route('admin.products.show', $product) }}" title="Voir">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </a>
                                <a class="btn btn-icon" href="{{ route('admin.products.edit', $product) }}" title="Modifier">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path>
                                        <path d="m15 5 4 4"></path>
                                    </svg>
                                </a>

                                {{-- suppression : formulaire POST + method DELETE --}}
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Supprimer ce produit ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-icon btn-danger" type="submit" title="Supprimer">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M3 6h18"></path>
                                            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="section-footer">
            <a href="{{ route('admin.products.index') }}" class="link">Voir tous les produits →</a>
        </div>
    </div>

    {{-- --- Commandes récentes (aperçu) --- --}}
    <div class="dashboard-section">
        <div class="section-header">
            <h3>Commandes récentes</h3>
            <div class="section-actions">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Voir toutes</a>
            </div>
        </div>

        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Client</th>
                        <th>Total</th>
                        <th>Statut</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                    <tr>
                        <td class="id">{{ $order->id }}</td>
                        <td class="name">{{ $order->customer_name ?? $order->email }}</td>
                        <td class="price">{{ number_format($order->total_amount,0,',',' ') }} CFA</td>
                        <td class="status">
                            <span class="status-badge status-{{ strtolower($order->status) }}">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="date">{{ $order->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
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
                    backgroundColor: 'rgba(79, 70, 229, 0.7)',
                    borderColor: 'rgba(79, 70, 229, 1)',
                    borderWidth: 1,
                    borderRadius: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            callback: function(value) {
                                return new Intl.NumberFormat('fr-FR').format(value) + ' CFA';
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }
    
    // Gestion du changement de période du graphique
    document.getElementById('chartPeriod')?.addEventListener('change', function(e) {
        // Ici vous pourriez faire un appel AJAX pour récupérer les données selon la période
        console.log('Changement de période:', e.target.value);
    });
</script>
@endpush

<style>
/* Variables CSS */
:root {
    --primary: #4f46e5;
    --primary-light: #eef2ff;
    --secondary: #64748b;
    --success: #10b981;
    --warning: #f59e0b;
    --danger: #ef4444;
    --light: #f8fafc;
    --dark: #1e293b;
    --gray: #94a3b8;
    --border: #e2e8f0;
    --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    --radius: 8px;
}

/* Styles généraux */
* {
    box-sizing: border-box;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    background-color: #f1f5f9;
    color: #334155;
    line-height: 1.5;
}

.page-header {
    margin-bottom: 2rem;
}

.page-header h1 {
    font-size: 1.875rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0 0 0.25rem 0;
}

.page-header .subtitle {
    color: #64748b;
    font-size: 0.875rem;
}

/* Cartes de statistiques */
.dashboard-cards {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    padding: 1.5rem;
    display: flex;
    align-items: flex-start;
    transition: transform 0.2s, box-shadow 0.2s;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.stat-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 3rem;
    height: 3rem;
    border-radius: 10px;
    margin-right: 1rem;
    flex-shrink: 0;
}

.stat-icon.product {
    background-color: #e0f2fe;
    color: #0369a1;
}

.stat-icon.order {
    background-color: #f3e8ff;
    color: #7c3aed;
}

.stat-icon.revenue {
    background-color: #dcfce7;
    color: #16a34a;
}

.stat-icon.customer {
    background-color: #fef3c7;
    color: #d97706;
}

.stat-content h3 {
    font-size: 0.875rem;
    font-weight: 500;
    color: #64748b;
    margin: 0 0 0.5rem 0;
}

.stat-content .big {
    font-size: 1.875rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0 0 0.25rem 0;
}

.stat-content .muted {
    font-size: 0.75rem;
    color: #94a3b8;
    margin: 0;
}

/* Sections du dashboard */
.dashboard-section {
    background: white;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    margin-bottom: 1.5rem;
    overflow: hidden;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--border);
}

.section-header h3 {
    font-size: 1.125rem;
    font-weight: 600;
    color: #0f172a;
    margin: 0;
}

.section-actions {
    display: flex;
    gap: 0.75rem;
    align-items: center;
}

.section-footer {
    padding: 1rem 1.5rem;
    border-top: 1px solid var(--border);
    text-align: right;
}

/* Grille pour les sections inférieures */
.dashboard-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}

/* Conteneur du graphique */
.chart-container {
    padding: 1.5rem;
    height: 300px;
}

/* Tables */
.table-container {
    overflow-x: auto;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th {
    background-color: #f8fafc;
    padding: 0.75rem 1rem;
    text-align: left;
    font-size: 0.75rem;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-bottom: 1px solid var(--border);
}

.table td {
    padding: 1rem;
    border-bottom: 1px solid var(--border);
}

.table tr:last-child td {
    border-bottom: none;
}

.table .id {
    font-weight: 600;
    color: #475569;
    font-size: 0.875rem;
}

.table .name a {
    color: #334155;
    text-decoration: none;
    font-weight: 500;
}

.table .name a:hover {
    color: var(--primary);
}

.table .price {
    font-weight: 600;
    color: #0f172a;
}

.table .date {
    font-size: 0.875rem;
    color: #64748b;
}

.table .text-center {
    text-align: center;
}

/* Boutons */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    font-size: 0.875rem;
    font-weight: 500;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-primary {
    background-color: var(--primary);
    color: white;
}

.btn-primary:hover {
    background-color: #4338ca;
}

.btn-secondary {
    background-color: #f1f5f9;
    color: #475569;
}

.btn-secondary:hover {
    background-color: #e2e8f0;
}

.btn-icon {
    padding: 0.5rem;
    border-radius: 6px;
}

.btn-danger {
    background-color: #fef2f2;
    color: var(--danger);
}

.btn-danger:hover {
    background-color: #fee2e2;
}

.action-buttons {
    display: flex;
    justify-content: center;
    gap: 0.25rem;
}

/* Badges */
.stock-badge {
    display: inline-block;
    padding: 0.25rem 0.5rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
}

.stock-badge.in-stock {
    background-color: #f0fdf4;
    color: #16a34a;
}

.stock-badge.low-stock {
    background-color: #fffbeb;
    color: #d97706;
}

.stock-badge.out-of-stock {
    background-color: #fef2f2;
    color: #dc2626;
}

.status-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
}

.status-pending {
    background-color: #fffbeb;
    color: #d97706;
}

.status-completed, .status-delivered {
    background-color: #f0fdf4;
    color: #16a34a;
}

.status-processing {
    background-color: #eff6ff;
    color: #2563eb;
}

.status-cancelled {
    background-color: #fef2f2;
    color: #dc2626;
}

/* Sélecteur */
.select {
    padding: 0.5rem 2rem 0.5rem 0.75rem;
    border-radius: 6px;
    border: 1px solid var(--border);
    background-color: white;
    font-size: 0.875rem;
    color: #334155;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.5rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    appearance: none;
}

/* Liens */
.link {
    color: var(--primary);
    text-decoration: none;
    font-weight: 500;
    font-size: 0.875rem;
}

.link:hover {
    text-decoration: underline;
}

/* Responsive */
@media (max-width: 1024px) {
    .dashboard-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .dashboard-cards {
        grid-template-columns: 1fr;
    }
    
    .section-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .section-actions {
        width: 100%;
        justify-content: flex-end;
    }
    
    .table th, .table td {
        padding: 0.75rem 0.5rem;
    }
    
    .action-buttons {
        flex-direction: column;
        gap: 0.5rem;
    }
}

@media (max-width: 640px) {
    .page-header h1 {
        font-size: 1.5rem;
    }
    
    .stat-card {
        padding: 1rem;
    }
    
    .section-header, .section-footer {
        padding: 1rem;
    }
    
    .chart-container {
        padding: 1rem;
        height: 250px;
    }
}
</style>