<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $products = Product::all();

        if ($users->isEmpty() || $products->isEmpty()) {
            return;
        }

        $comments = [
            'ممتاز جداً، أنصح به',
            'جودة عالية وسعر مناسب',
            'المنتج جيد لكن التوصيل تأخر',
            'لم يعجبني، توقعت أفضل',
            'رائع! سأشتري مرة أخرى',
            'منتج ممتاز كما في الوصف',
            'السعر مرتفع قليلاً',
            'جودة ممتازة وتغليف جيد',
        ];

        // مصفوفة لتتبع الأزواج المُستخدمة
        $used = [];
        $created = 0;
        $attempts = 0;

        while ($created < 30 && $attempts < 300) {
            $attempts++;

            $userId = $users->random()->id;
            $productId = $products->random()->id;
            $key = "{$userId}-{$productId}";

            // تجاوز التكرار
            if (in_array($key, $used)) {
                continue;
            }

            $used[] = $key;

            Review::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'rating' => rand(1, 5),
                'comment' => $comments[array_rand($comments)],
                'is_approved' => (bool) rand(0, 1),
            ]);

            $created++;
        }
    }
}