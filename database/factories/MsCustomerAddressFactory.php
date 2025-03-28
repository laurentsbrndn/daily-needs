<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\MsCustomer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MsCustomerAddress>
 */
class MsCustomerAddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_address_name' => $this->faker->name(),
            'customer_address_street' => $this->faker->streetAddress(),
            'customer_address_postal_code' => $this->faker->postcode(),
            'customer_address_district' => $this->faker->citySuffix(),
            'customer_address_regency_city' => $this->faker->city(), 
            'customer_address_province' => $this->faker->state(),
            'customer_address_country' => $this->faker->country(),

            'customer_id' => MsCustomer::inRandomOrder()->first()->customer_id ?? MsCustomer::factory(),
        ];
    }
}
