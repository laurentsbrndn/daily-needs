<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MsCustomer>
 */
class MsCustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_first_name' => $this->faker->firstName,
            'customer_last_name' => $this->faker->lastName,
            'customer_email' => $this->faker->unique()->safeEmail(),
            'customer_password' => $this->faker->password(8, 20),
            'customer_phone_number' => $this->faker->phoneNumber,
            'customer_address' => $this->faker->address,
            'customer_photo' => $this->faker->name,
            'customer_gender' => $this->faker->randomElement(['Male', 'Female', 'Prefer not to say']),
            'customer_balance' => $this->faker->randomFloat(2, 0, 10000000000),
        ];
    }
}
