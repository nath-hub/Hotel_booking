<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Booking;

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
     * Determine if the user can show a booking.
     */
    public function index(User $user): bool
    {
        return true;
    }

      /**
     * Determine if the user can show one booking.
     */
    public function show(User $user): bool
    {
        return true;
    }


    /**
     * Determine if the user can create a booking.
     */
    public function create(User $user, array $bookingData): bool
    {
        return $user->is_director ||
            $user->is_receptionist ||
            $user->is_booker && $user->id = $bookingData['user_id'];
    }


    /**
     * Determine if the user can update a booking.
     */
    public function update(User $user, Booking $booking, array $input): bool
    {

        $booking->load('people.user');

        return $user->is_director ||
            $user->is_receptionist ||
            $user->is_booker && $user->id = $booking->people->user->id &&
            !isset($input['validated']);
    }
}
