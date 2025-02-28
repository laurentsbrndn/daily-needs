<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MsCourier>
 */
class MsCourierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'courier_first_name' => $this->faker->firstName,
            'courier_last_name' => $this->faker->lastName,
            'courier_email' => $this->faker->unique()->safeEmail(),
            'courier_password' => $this->faker->password(8, 20),
            'courier_phone_number' => $this->faker->phoneNumber,
            'courier_address' => $this->faker->address,
            'courier_photo' => $this->faker->name,
            'courier_gender' => $this->faker->randomElement(['Male', 'Female', 'Prefer not to say']),
        ];
    }
}
