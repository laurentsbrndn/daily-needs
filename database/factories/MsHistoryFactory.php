<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\MsCustomer;
use App\Models\MsShipment;
use App\Models\MsPaymentMethod;
use App\Models\TransactionHeader;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MsCart>
 */
class MsHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'transaction_date' => $this->faker->dateTimeThisYear(),
            'total_price' => $this->faker->randomFloat(2, 0, 100000),
            
            'customer_id' => MsCustomer::inRandomOrder()->first()->customer_id ?? MsCustomer::factory(),
            'shipment_id' => MsShipment::inRandomOrder()->first()->shipment_id ?? MsShipment::factory(),
            'transaction_id' => TransactionHeader::inRandomOrder()->first()->transaction_id ?? TransactionHeader::factory(),
            'payment_method_id' => MsPaymentMethod::inRandomOrder()->first()->payment_method_id ?? MsPaymentMethod::factory(),
        ];
    }
}
