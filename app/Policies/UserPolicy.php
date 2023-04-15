<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
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

    /**
     * Determine if the  receptionist can update his account.
     */
    public function update(User $user, User $userToUpdate): bool
    {
        return $user->people->type === 'DIRECTOR' && $userToUpdate->people->type !== 'DIRECTOR' ||
        $user->people->type === 'RECEPTIONIST' && $userToUpdate->people->type === 'ADULT' ||
        $user->id === $userToUpdate->id;
    }
}
