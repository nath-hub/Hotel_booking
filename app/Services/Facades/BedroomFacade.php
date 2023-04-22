<?php

namespace App\Services\Facades;

use App\Services\BedroomService;
use Illuminate\Support\Facades\Facade;

/**
 * Facade for user service
 */
class BedroomFacade extends Facade
{

    /**
     * Returning service name
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return BedroomService::class;
    }
}
