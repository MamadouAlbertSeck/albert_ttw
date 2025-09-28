<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
// use App\Models\Visitor; // si tu as un modèle Visitor
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistiques globales
        $totalProducts = Product::count();
        $totalOrders   = Order::count();
        $totalRevenue  = (float) \App\Models\Order::sum('total_amount');

        // Optionnel : visiteurs si tu stockes ça
        // $totalVisitors = Visitor::count();

        // Produits récents (pour affichage rapide)
        $recentProducts = Product::latest()->take(5)->get();

        // Commandes récentes (pour aperçu)
        $recentOrders = Order::latest()->take(5)->get();

        // Chiffre d'affaire par mois (exemple simple)
        $monthlySales = Order::selectRaw('MONTH(created_at) as month, SUM(total_amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.dashboard', compact(
            'totalProducts','totalOrders','totalRevenue',
            //'totalVisitors',
            'recentProducts','recentOrders','monthlySales'
        ));
    }
}
