<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Database\Seeder;

class WishlistSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $products = Product::all();

        if ($users->isEmpty() || $products->isEmpty()) {
            return;
        }

        foreach (range(1, 25) as $i) {
            Wishlist::firstOrCreate([
                'user_id' => $users->random()->id,
                'product_id' => $products->random()->id,
            ]);
        }
    }
}