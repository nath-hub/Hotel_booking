<?php

namespace App\Services\Facades;

use App\Services\ReceptionistService;
use Illuminate\Support\Facades\Facade;

/**
 * Facade for user service
 */
class ReceptionistFacade extends Facade
{

    /**
     * Returning service name
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return ReceptionistService::class;
    }
}
