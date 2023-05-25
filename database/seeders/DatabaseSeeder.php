<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Bedroom;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Hotel;
use App\Models\People;
use App\Models\ShowerRoom;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $hotel = Hotel::factory()
            ->create();

        $user = User::factory()->for(People::factory()->state([
            'type' => 'DIRECTOR'
        ])->for($hotel))->create();

        for ($i = 0; $i < 25; $i++) {
            $receptionist = User::factory()->for(People::factory()->state([
                'type' => 'RECEPTIONIST',
            ])->for($hotel))->create();
        }

        for ($i = 0; $i < 25; $i++) {
            User::factory()->for(People::factory()->state([
                'type' => 'ADULT',
                'hotel_id' => null,
            ])->for($hotel))->create();
        }

        // $bedrooms = Bedroom::factory()->for(ShowerRoom::factory())->for($hotel)->create();

        $showerRoom = ShowerRoom::factory()->count(5)->create();

        // $booking = Booking::factory()->count(5)->create();
    }
}
