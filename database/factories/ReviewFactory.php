<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'product_id' => Product::factory(),
            'rating' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->randomElement([
                'ممتاز جداً، أنصح به',
                'جودة عالية وسعر مناسب',
                'المنتج جيد لكن التوصيل تأخر',
                'لم يعجبني، توقعت أفضل',
                'رائع! سأشتري مرة أخرى',
                'منتج ممتاز كما في الوصف',
                'السعر مرتفع قليلاً',
                'جودة ممتازة وتغليف جيد',
            ]),
            'is_approved' => $this->faker->boolean(70),
        ];
    }
}