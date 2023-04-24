<?php

namespace App\Policies;

use App\Models\User;

class BookingPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the user can create a booking.
     */
    public function create(User $user): bool
    {
        return $user->is_director || $user->is_receptionist || $user->is_booker;
    }
}
