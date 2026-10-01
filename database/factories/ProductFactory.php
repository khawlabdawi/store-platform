<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->randomElement([
            'قميص', 'بنطال', 'حذاء', 'حقيبة', 'ساعة',
            'جاكيت', 'نظارة', 'قبعة', 'وشاح', 'حزام',
        ]) . ' ' . $this->faker->numberBetween(1, 500);

        $price = $this->faker->randomFloat(2, 10, 500);

        return [
            'category_id' => Category::factory(),
            'name' => $name,
            'slug' => Str::slug($name) . '-' . $this->faker->unique()->numberBetween(1, 99999),
            'description' => $this->faker->paragraph(),
            'price' => $price,
            'sale_price' => $this->faker->boolean(30) ? $price * 0.8 : null,
            'stock' => $this->faker->numberBetween(0, 100),
            'image' => null,
            'is_active' => $this->faker->boolean(90),
        ];
    }
}