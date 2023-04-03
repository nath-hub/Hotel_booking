<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Hotel;
use App\Models\People;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $hotel = Hotel::factory()
        ->for(Category::factory())
        ->create();

        $director = People::factory()->make([
            'type' => 'DIRECTOR',
        ])->for($hotel)->create();
        

        $employees = People::factory()->count(9)->make([
            'type' => 'EMPLOYEE',
        ])->for($hotel)->create();
    }
}
