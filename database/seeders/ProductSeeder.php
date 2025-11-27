<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        if (Product::count() > 0) return;
        Product::create([
            'name' => 'Air Mineral 600ml',
            'sku' => 'AM600',
            'price' => 3000,
            'stock' => 120,
            'pack_size' => 12,
            'pack_label' => 'pcs',
            'discount_type' => 'none',
            'discount_value' => 0,
        ]);
        Product::create([
            'name' => 'Mie Instan Ayam',
            'sku' => 'MIA01',
            'price' => 3500,
            'stock' => 240,
            'pack_size' => 40,
            'pack_label' => 'pcs',
            'discount_type' => 'percent',
            'discount_value' => 10,
        ]);
    }
}
