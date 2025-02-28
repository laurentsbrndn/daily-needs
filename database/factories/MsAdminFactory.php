<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MsAdmin>
 */
class MsAdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'admin_first_name' => $this->faker->firstName,
            'admin_last_name' => $this->faker->lastName,
            'admin_email' => $this->faker->unique()->safeEmail(),
            'admin_password' => $this->faker->password(8, 20),
            'admin_phone_number' => $this->faker->phoneNumber,
            'admin_address' => $this->faker->address,
            'admin_photo' => $this->faker->name,
            'admin_gender' => $this->faker->randomElement(['Male', 'Female', 'Prefer not to say']),
        ];
    }
}