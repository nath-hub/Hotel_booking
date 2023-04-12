<?php

namespace Database\Factories;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bedroom>
 */
class BedroomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => fake()->address(),
            'bed_number' => fake()->numberBetween(1,12),
            'price' => fake()->numberBetween(1,5),
            'hotel_id' => Hotel::factory(),
        ];
    }
}
