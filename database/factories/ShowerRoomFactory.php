<?php

namespace Database\Factories;

use App\Models\Bedroom;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShowerRoom>
 */
class ShowerRoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => fake()->randomElement(['SHOWER', 'BATHTUB']),
            'bedroom_id' => Bedroom::factory(),
        ];
    }
}
