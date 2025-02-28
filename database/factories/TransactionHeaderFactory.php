<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\MsAdmin;
use App\Models\MsCustomer;
use App\Models\MsPaymentMethod;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransactionHeader>
 */
class TransactionHeaderFactory extends Factory
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
            'transaction_total_price' => $this->faker->randomFloat(2, 0, 1000000),
            'transaction_status' => $this->faker->randomElement(['Pending', 'Completed', 'Cancelled']),

            'admin_id' => MsAdmin::inRandomOrder()->first()->admin_id ?? MsAdmin::factory(),
            'customer_id' => MsCustomer::inRandomOrder()->first()->customer_id ?? MsCustomer::factory(),
            'payment_method_id' => MsPaymentMethod::inRandomOrder()->first()->payment_method_id ?? MsPaymentMethod::factory(),
        ];
    }
}
