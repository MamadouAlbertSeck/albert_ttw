<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class PaymentController extends Controller
{
    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $signature = $request->header('X-PAYMENT-SIGNATURE'); // adapter selon provider
        $secret = env('PAYMENT_WEBHOOK_SECRET');

        // Vérification signature (ex. HMAC)
        $calculated = hash_hmac('sha256', $payload, $secret);
        if(!hash_equals($calculated, $signature)){
            return response()->json(['error'=>'Invalid signature'], 400);
        }

        $data = json_decode($payload, true);
        $orderRef = $data['order_reference'] ?? null;
        $status = $data['status'] ?? null;

        if($orderRef && $status === 'paid'){
            $order = Order::where('id', $orderRef)->first();
            if($order){
                $order->status = 'paid';
                $order->payment_reference = $data['payment_id'] ?? null;
                $order->save();
            }
        }

        return response()->json(['success'=>true]);
    }
}
