<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::insert([
            [
                'name' => 'Apples',
                'price' => 2.99,
                'stock' => 100,
                'description' => 'Fresh red apples'
            ],
            [
                'name' => 'Bananas',
                'price' => 1.49,
                'stock' => 150,
                'description' => 'Organic bananas'
            ],
            [
                'name' => 'Oranges',
                'price' => 3.25,
                'stock' => 80,
                'description' => 'Juicy oranges'
            ]
        ]);
    }
}
