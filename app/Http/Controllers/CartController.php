<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // Affiche panier
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        foreach($cart as $item){
            $total += $item['price'] * $item['quantity'];
        }
        return view('cart.index', compact('cart', 'total'));
    }

    // Ajouter produit au panier
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if(isset($cart[$id])){
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Produit ajouté au panier !');
    }

    // Mettre à jour le panier (quantités)
    public function update(Request $request)
    {
        $cart = session()->get('cart', []);
        if($request->has('quantities')){
            foreach($request->quantities as $id => $qty){
                if(isset($cart[$id])){
                    $cart[$id]['quantity'] = max(1, (int)$qty);
                }
            }
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Panier mis à jour.');
    }

    // Supprimer un produit
    public function remove(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$id])){
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Produit supprimé du panier.');
    }
}
