<?php

namespace Database\Factories;

use App\Models\Bedroom;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'start_date' => fake()->dateTime(),
            'end_date' => fake()->dateTime(),
            'validated' => fake()->numberBetween(1,5),
            'booker_id' => User::factory(),
            'bedroom_id' => Bedroom::factory(),
        ];
    }
}
