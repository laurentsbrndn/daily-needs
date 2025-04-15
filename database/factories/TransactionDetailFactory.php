<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\TransactionHeader;
use App\Models\TransactionDetail;
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
        $transaction = TransactionHeader::inRandomOrder()->first() ?? TransactionHeader::factory()->create();
        $product = MsProduct::inRandomOrder()->first() ?? MsProduct::factory()->create();
    
        while (TransactionDetail::where('transaction_id', $transaction->transaction_id)
                ->where('product_id', $product->product_id)
                ->exists()) {
            $product = MsProduct::inRandomOrder()->first() ?? MsProduct::factory()->create();
        }
    
        return [
            'transaction_id' => $transaction->transaction_id,
            'product_id' => $product->product_id,
            'quantity' => $this->faker->numberBetween(1, 10),
            'unit_price_at_buy' => $this->faker->randomFloat(2, 0, 10000000000),
        ];
    }

}