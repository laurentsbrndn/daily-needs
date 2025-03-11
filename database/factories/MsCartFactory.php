<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\MsCustomer;
use App\Models\MsProduct;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MsCart>
 */
class MsCartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'quantity' => $this->faker->numberBetween(1, 10),
            
            'customer_id' => MsCustomer::inRandomOrder()->first()->customer_id ?? MsCustomer::factory(),
            'product_id' => MsProduct::inRandomOrder()->first()->product_id ?? MsProduct::factory(),
        ];
    }
}
