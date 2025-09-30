<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run()
    {
        $products = Product::all();

        if ($products->count() === 0) {
            $this->command->info("Aucun produit trouvé. Crée d'abord des produits dans la table products.");
            return;
        }

        // Liste de noms et adresses plausibles au Sénégal
        $senegalAddresses = [
            [
                'customer_name' => 'Fatou Ndiaye',
                'phone' => '+221 77 123 45 67',
                'street' => '23 Avenue Lamine Guèye',
                'city' => 'Dakar',
                'postal_code' => '12000',
                'email' => 'fatou.ndiaye@example.sn',
            ],
            [
                'customer_name' => 'Mamadou Diop',
                'phone' => '+221 77 987 65 43',
                'street' => '12 Rue du Commerce',
                'city' => 'Dakar',
                'postal_code' => '12033',
                'email' => 'mamadou.diop@example.sn',
            ],
            [
                'customer_name' => 'Aissatou Sow',
                'phone' => '+221 77 111 22 33',
                'street' => '5 Rue de la République',
                'city' => 'Saint-Louis',
                'postal_code' => '32000',
                'email' => 'aissatou.sow@example.sn',
            ],
            [
                'customer_name' => 'Cheikh Fall',
                'phone' => '+221 77 444 55 66',
                'street' => '8 Avenue du Port',
                'city' => 'Thiès',
                'postal_code' => '21000',
                'email' => 'cheikh.fall@example.sn',
            ],
            [
                'customer_name' => 'Adama Diallo',
                'phone' => '+221 77 555 66 77',
                'street' => '14 Boulevard de la Gare',
                'city' => 'Ziguinchor',
                'postal_code' => '66000',
                'email' => 'adama.diallo@example.sn',
            ],
            [
                'customer_name' => 'Seynabou Ndiaye',
                'phone' => '+221 77 888 99 00',
                'street' => '3 Rue des Jardins',
                'city' => 'Kaolack',
                'postal_code' => '43000',
                'email' => 'seynabou.ndiaye@example.sn',
            ],
            [
                'customer_name' => 'Ousmane Thiam',
                'phone' => '+221 77 222 33 44',
                'street' => '7 Rue du Marché',
                'city' => 'Dakar',
                'postal_code' => '12012',
                'email' => 'ousmane.thiam@example.sn',
            ],
            [
                'customer_name' => 'Mariama Cissé',
                'phone' => '+221 77 333 44 55',
                'street' => '9 Avenue de la Liberté',
                'city' => 'Saint-Louis',
                'postal_code' => '32010',
                'email' => 'mariama.cisse@example.sn',
            ],
        ];

        $providers = ['PayPal', 'Orange Money', 'Tigo Cash'];

        // Créer 20 commandes
        for ($i = 0; $i < 20; $i++) {
            $addr = $senegalAddresses[array_rand($senegalAddresses)];

            $createdAt = Carbon::now()->subDays(rand(0, 90))->subHours(rand(0,23))->subMinutes(rand(0,59));

            $order = Order::create([
                'customer_name' => $addr['customer_name'],
                'phone' => $addr['phone'],
                'street' => $addr['street'],
                'city' => $addr['city'],
                'postal_code' => $addr['postal_code'],
                'email' => $addr['email'],
                'status' => collect(['en cours','paid','shipped','canceled'])->random(),
                'total_amount' => 0,
                'payment_provider' => $providers[array_rand($providers)],
                'payment_reference' => strtoupper(str_replace(' ', '', substr(md5(uniqid(rand(), true)), 0, 10))),
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            $itemsCount = rand(1, min(4, $products->count()));
            $selectedProducts = $products->random($itemsCount);
            $total = 0;

            foreach ($selectedProducts as $product) {
                $quantity = rand(1, 3);
                $unitPrice = (float) $product->price;
                $linePrice = $unitPrice * $quantity;

                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $linePrice,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);

                $total += $linePrice;
            }

            $order->update([
                'total_amount' => $total,
                'updated_at' => $createdAt->copy()->addMinutes(rand(1,120)),
            ]);
        }

        $this->command->info("20 commandes créées avec adresses sénégalaises réalistes.");
    }
}
