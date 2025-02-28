<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\MsBrand;
use App\Models\MsCompany;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MsBrand>
 */
class MsBrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $brandName = $this->faker->words(2, true);

        return [
            'brand_name' => $this->faker->words(2, 3),
            'brand_slug' => Str::slug($brandName),
            'company_id' => MsCompany::inRandomOrder()->first()->company_id ?? MsCompany::factory(),
        ];
    }
}
