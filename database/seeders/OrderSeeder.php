<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class OrderSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();
        $products = Product::all();

        for ($i = 1; $i <= 20; $i++) {
            $order = Order::create([
                'customer_name' => $faker->name(),
                'phone' => $faker->phoneNumber(),
                'street' => $faker->streetAddress(),
                'city' => $faker->city(),
                'postal_code' => $faker->postcode(),
                'email' => $faker->email(),
                'status' => 'en cours',
                'total_amount' => 0, // sera calculé
                'payment_provider' => $faker->randomElement(['PayPal', 'Orange Money', 'Tigo Cash']),
                'payment_reference' => strtoupper($faker->bothify('???-#####')),
            ]);

            // Ajouter 1 à 5 produits à la commande
            $itemsCount = rand(1, 5);
            $total = 0;

            $selectedProducts = $products->random($itemsCount);
            foreach ($selectedProducts as $product) {
                $quantity = rand(1, 3);
                $price = $product->price * $quantity;

                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                ]);

                $total += $price;
            }

            // Mettre à jour le total_amount
            $order->update(['total_amount' => $total]);
        }
    }
}
