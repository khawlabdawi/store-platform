<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $products = Product::all();

        if ($users->isEmpty() || $products->isEmpty()) {
            return;
        }

        foreach (range(1, 20) as $i) {
            $order = Order::factory()->create([
                'user_id' => $users->random()->id,
            ]);

            $itemCount = rand(1, 4);
            $total = 0;

            foreach (range(1, $itemCount) as $j) {
                $product = $products->random();
                $quantity = rand(1, 3);
                $price = $product->price;
                $total += $price * $quantity;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                ]);
            }

            $order->update(['total' => $total]);
        }
    }
}