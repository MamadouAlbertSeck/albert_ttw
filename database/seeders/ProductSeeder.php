<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();

        for ($i = 1; $i <= 50; $i++) {
            Product::create([
                'name' => $faker->word(),
                'slug' => $faker->slug(),
                'description' => $faker->sentence(),
                'price' => $faker->numberBetween(1000, 20000),
                'stock' => $faker->numberBetween(1, 100),
                'image' => 'products/placeholder.jpg', // image factice
            ]);
        }
    }
}
