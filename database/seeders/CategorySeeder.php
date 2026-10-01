<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'رجالي', 'slug' => 'men'],
            ['name' => 'نسائي', 'slug' => 'women'],
            ['name' => 'أطفال', 'slug' => 'kids'],
            ['name' => 'إلكترونيات', 'slug' => 'electronics'],
            ['name' => 'منزل', 'slug' => 'home'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat + ['is_active' => true]);
        }

        Category::factory(5)->create();
    }
}