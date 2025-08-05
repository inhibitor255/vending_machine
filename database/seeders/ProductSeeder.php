<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Product::create(['name' => 'Coke', 'price' => 3.99, 'quantity' => 100]);
        \App\Models\Product::create(['name' => 'Pepsi', 'price' => 6.885, 'quantity' => 100]);
        \App\Models\Product::create(['name' => 'Water', 'price' => 0.5, 'quantity' => 100]);
    }
}
