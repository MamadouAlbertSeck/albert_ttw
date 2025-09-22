<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    // Listing produits
    public function index()
    {
        $products = Product::paginate(12); // pagination
        return view('products.index', compact('products'));
    }

    // Page détail produit
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        return view('products.show', compact('product'));
    }
}
