<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\MsBrand;
use App\Models\MsCategory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MsProduct>
 */
class MsProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $productName = $this->faker->words(2, true);

        return [
            'product_name' => $this->faker->words(2, 3),
            'product_price' => $this->faker->randomFloat(2, 0, 100000),
            'product_stock' => $this->faker->numberBetween(0, 100),
            'product_image' => $this->faker->name,
            'product_description' => $this->faker->sentence,
            'product_slug' => Str::slug($productName),

            'brand_id' => MsBrand::inRandomOrder()->first()->brand_id ?? MsBrand::factory(),
            'category_id' => MsCategory::inRandomOrder()->first()->category_id ?? MsCategory::factory(),
        ];
    }
}