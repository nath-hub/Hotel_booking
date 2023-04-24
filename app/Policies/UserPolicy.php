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
        return $user->is_director;
    }


    /**
     * Determine if the user can create a booker.
     */
    public function createBooker(?User $user): bool
    {
        if ($user === null) {
            return true;
        }else{
            return $user->is_director || $user->is_receptionist;
        }
    }

    /**
     * Determine if the  receptionist can update his account.
     */
    public function update(User $user, User $userToUpdate): bool
    {
        return $user->is_director && $userToUpdate->people->type !== 'DIRECTOR' ||
            $user->is_receptionist && $userToUpdate->is_booker ||
            $user->id === $userToUpdate->id;
    }

    /**
     * Verify if user can delete his account of receptionist
     */
    public function delete(User $user, User $userToDelete)
    {
        return $user->is_director && $userToDelete->is_receptionist;
    }
}
