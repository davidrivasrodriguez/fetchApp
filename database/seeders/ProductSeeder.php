<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 200; $i++) {
            $product = new Product();
            $product->name = Str::random(20);
            // $product->name = fake()->unique()->word();  
            $product->price = fake()->numberBetween(1, 200);
            $product->save();
        }
    }
}