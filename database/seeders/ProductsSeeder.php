<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Categories;
use App\Models\Products;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $categories = Categories::pluck('id');
        $brands = Brand::pluck('id');

        foreach ($categories as $categoryId) {
            for ($i = 0; $i < 20; $i++) {
                Products::insert([
                    'title' => $faker->name,
                    'price' => $faker->randomFloat(2, 100000, 10000000),
                    'stock' => $faker->numberBetween(10, 50),
                    'category_id' => $categoryId,
                    'brand_id' => $brands->random(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
