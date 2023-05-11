<?php

namespace App\Services\Facades;

use App\Services\BookingService;
use Illuminate\Support\Facades\Facade;

/**
 * Facade for user service
 */
class BookingFacade extends Facade
{

    /**
     * Returning service name
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return BookingService::class;
    }
}
