<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'order_number' => 'ORD-' . strtoupper($this->faker->unique()->bothify('??####')),
            'status' => $this->faker->randomElement([
                'pending', 'processing', 'shipped', 'delivered', 'cancelled',
            ]),
            'total' => 0, // سيُحدَّث لاحقاً في الـ Seeder
            'shipping_address' => $this->faker->address(),
            'phone' => $this->faker->phoneNumber(),
            'notes' => $this->faker->boolean(30) ? $this->faker->sentence() : null,
        ];
    }
}