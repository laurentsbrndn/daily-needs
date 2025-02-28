<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MsPaymentMethod>
 */
class MsPaymentMethodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'payment_method_name' => $this->faker->unique()->randomElement(['Bank Transfer', 'Cash on Delivery', 'Application Balance']),
        ];
    }
}
