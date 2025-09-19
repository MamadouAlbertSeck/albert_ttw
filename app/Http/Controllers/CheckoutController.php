<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if(empty($cart)){
            return redirect()->route('home')->with('error','Votre panier est vide.');
        }
        $total = 0;
        foreach($cart as $item){
            $total += $item['price'] * $item['quantity'];
        }
        return view('checkout.index', compact('cart','total'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'name'=>'required|string|max:255',
            'phone'=>'required|string|max:20',
            'street'=>'required|string|max:255',
            'city'=>'required|string|max:255',
            'postal_code'=>'nullable|string|max:20',
            'email'=>'nullable|email|max:255',
        ]);

        $cart = session()->get('cart', []);
        if(empty($cart)){
            return redirect()->route('home')->with('error','Votre panier est vide.');
        }

        DB::transaction(function() use($request, $cart){
            $total = 0;
            foreach($cart as $item){
                $total += $item['price'] * $item['quantity'];
            }

            $order = Order::create([
                'customer_name' => $request->name,
                'phone' => $request->phone,
                'street' => $request->street,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'email' => $request->email,
                'status' => 'pending',
                'total_amount' => $total,
                'payment_provider' => 'paydunya', // adapter si autre provider
            ]);

            foreach($cart as $id => $item){
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            // Ici préparer invoice / redirection vers prestataire paiement
            // Exemple : $paymentUrl = PaymentService::createInvoice($order);
            // return redirect($paymentUrl);
        });

        session()->forget('cart');

        return redirect()->route('checkout.success')->with('success','Commande créée avec succès.');
    }

    public function success()
    {
        return view('checkout.success');
    }
}
