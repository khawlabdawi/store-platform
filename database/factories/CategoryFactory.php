<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->randomElement([
            'رجالي', 'نسائي', 'أطفال', 'إلكترونيات', 'منزل',
            'رياضة', 'كتب', 'ألعاب', 'عطور', 'أحذية',
        ]) . ' ' . $this->faker->numberBetween(1, 100);

        return [
            'name' => $name,
            'slug' => Str::slug($name) . '-' . $this->faker->unique()->numberBetween(1, 9999),
            'description' => $this->faker->sentence(),
            'is_active' => $this->faker->boolean(80),
        ];
    }
}