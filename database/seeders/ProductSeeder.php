<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'user_id' => 1,
            'category_id' => 1,
            'title' => 'iPhone 14',
            'description' => 'Smartphone Apple iPhone 14 128Go',
            'price' => 2999.99,
            'stock' => 10,
        ]);

        Product::create([
            'user_id' => 1,
            'category_id' => 1,
            'title' => 'Samsung Galaxy S23',
            'description' => 'Smartphone Samsung 256Go',
            'price' => 2499.99,
            'stock' => 15,
        ]);

        Product::create([
            'user_id' => 1,
            'category_id' => 2,
            'title' => 'T-Shirt Nike',
            'description' => 'T-Shirt sport Nike taille M',
            'price' => 89.99,
            'stock' => 50,
        ]);

        Product::create([
            'user_id' => 1,
            'category_id' => 3,
            'title' => 'Café Arabica',
            'description' => 'Café Arabica 100% naturel 500g',
            'price' => 24.99,
            'stock' => 100,
        ]);

        Product::create([
            'user_id' => 1,
            'category_id' => 4,
            'title' => 'Canapé moderne',
            'description' => 'Canapé 3 places tissu gris',
            'price' => 1299.99,
            'stock' => 5,
        ]);

        Product::create([
            'user_id' => 2,
            'category_id' => 5,
            'title' => 'Vélo de sport',
            'description' => 'Vélo 21 vitesses aluminium',
            'price' => 799.99,
            'stock' => 8,
        ]);
    }
}