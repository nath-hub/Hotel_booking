<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Bedroom;
use App\Models\People;
use App\Models\ShowerRoom;
use App\Policies\BedroomPolicy;
use App\Policies\PeoplePolicy;
use App\Policies\ShowerRomPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models\Bedroom' => 'App\Policies\BedroomPolicy',
        Bedroom::class => BedroomPolicy::class,

        'App\Models\ShowerRoom' => 'App\Policies\ShowerRom',
        ShowerRoom::class => ShowerRomPolicy::class,

        'App\Models\People' => 'App\Policies\PeoplePolicy',
        People::class => PeoplePolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
