<?php

namespace App\Policies;

use App\Models\People;
use App\Models\User;

class PeoplePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the user can create a receptionist.
     */
    public function createReceptionist(User $user): bool
    {
        return $user->people->type === 'DIRECTOR';
    }
}
