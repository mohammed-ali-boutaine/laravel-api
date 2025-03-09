<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 50; $i++) {
            Product::create([
                'name'        => $faker->word, // Use `word` for product names
                'description' => $faker->sentence,
                'price'       => $faker->randomFloat(2, 10, 1000), // 2 decimal places, range 10-1000
                'image_src'   => $faker->imageUrl(640, 480, 'products'), // Generates an image URL
            ]);
        }
    }
}
