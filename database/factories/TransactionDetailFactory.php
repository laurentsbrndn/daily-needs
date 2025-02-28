<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\TransactionHeader;
use App\Models\MsProduct;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransactionDetail>
 */
class TransactionDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'transaction_id' => TransactionHeader::inRandomOrder()->first()->transaction_id ?? TransactionHeader::factory(),
            'product_id' => MsProduct::inRandomOrder()->first()->product_id ?? MsProduct::factory(),
            'quantity' => $this->faker->numberBetween(1, 10),
        ];
    }
}