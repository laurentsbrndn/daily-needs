<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\MsCustomer;
use App\Models\MsPaymentMethod;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MsTopUp>
 */
class MsTopUpFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'top_up_amount' => $this->faker->randomFloat(2, 10000, 1000000),
            'top_up_date' => $this->faker->dateTimeThisYear(),
            'customer_id' => MsCustomer::query()->inRandomOrder()->value('customer_id') ?? MsCustomer::factory(),
            'payment_method_id' => 1,
            //'payment_method_id' => MsPaymentMethod::query()->inRandomOrder()->value('payment_method_id') ?? MsPaymentMethod::factory(),
        ];
    }
}
