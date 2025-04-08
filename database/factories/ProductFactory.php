<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model= Product::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ma_san_pham' => $this->faker->unique()->numerify('SP####'),
            // 'ma_san_pham'=> $this->faker->unique()->regexify('[A-Z0-9]{10}'),
            'ten_san_pham'=> $this->faker->word(),
            'gia'=> $this->faker->randomFloat(2,1000,10000000),
            'gia_khuyen_mai'=> $this->faker->optional()->randomFloat(2,1000,10000000),
            'so_luong'=> $this->faker->numberBetween(1,100),
            'ngay_nhap'=> $this->faker->dateTime(),
            'mo_ta'=> $this->faker->text(),
            'trang_thai'=> $this->faker->boolean(),
            'category_id'=> Category::inRandomOrder()->value('id') ?? Category::factory(),
        ];
    }
}
