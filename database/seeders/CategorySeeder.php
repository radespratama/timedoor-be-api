<?php

namespace Database\Seeders;

use App\Models\Categories;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Electronics',
            'Fashion',
            'Home & Kitchen',
            'Health & Beauty',
            'Sports & Outdoors',
            'Toys & Games',
            'Automotive',
            'Books',
            'Grocery',
            'Movies & TV',
        ];

        foreach ($categories as $category) {
            Categories::create([
                'name' => $category,
            ]);
        }
    }
}
