<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Bedroom;
use App\Models\Category;
use App\Models\Hotel;
use App\Models\People;
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



        $receptionist = User::factory()->for(People::factory()->state([
            'type' => 'RECEPTIONIST',
        ])->for($hotel))->create();

        $admin = User::factory()->for(People::factory()->state([
            'type' => 'SUPERADMIN',
        ])->for($hotel))->create();

        $bedroom = Bedroom::factory()->count(5)->create();


        /* $director = People::factory()->state([
            'type'=> 'DIRECTOR'
        ])->for($hotel)->create(); */


        /* $receptionist = People::factory()->count(2)->state([
            'type' => 'RECEPTIONIST',
        ])->for($hotel)->create(); */
    }
}
