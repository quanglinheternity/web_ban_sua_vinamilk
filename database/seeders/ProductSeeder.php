<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Category::factory()->count(5)->create()->each(function ($category){
        //     Product::factory()->count(9)->create(['category_id' => $category->id]);
        // });
        Product::factory()->count(9)->create();

    }
}
