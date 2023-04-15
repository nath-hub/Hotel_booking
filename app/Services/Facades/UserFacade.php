<?php

namespace App\Services\Facades;

use App\Services\UserService;
use Illuminate\Support\Facades\Facade;

/**
 * Facade for user service
 */
class UserFacade extends Facade
{

    /**
     * Returning service name
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return UserService::class;
    }
}
