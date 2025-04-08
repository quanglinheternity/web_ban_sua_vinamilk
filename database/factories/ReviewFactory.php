<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::inRandomOrder()->value('id') ?? Product::factory(),
            'customer_id' => Customer::inRandomOrder()->value('id') ?? Customer::factory(),
            'rating' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->text(),
        ];
    }
}
