<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ten_khach_hang' => $this->faker->lastName() . ' ' . $this->faker->firstName(), // Họ + Tên
            'email' => $this->faker->unique()->safeEmail(), // Email duy nhất
            'so_dien_thoai' => $this->faker->unique()->numerify('0#########'), // Số điện thoại chuẩn Việt Nam
            'dia_chi' => $this->faker->streetAddress() . ', ' . $this->faker->city() . ', ' . $this->faker->state(), // Địa chỉ đầy đủ
        ];
    }
}
