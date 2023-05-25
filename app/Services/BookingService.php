<?php

namespace App\Services;

use App\Models\Bedroom;
use App\Models\Booking;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BookingService
{
    /**
     * show all booking
     * 
     * @return array
     */
    public function index()
    {

        $allBooking = DB::table('bedroom_people')
            ->where('start_date', '>=', Carbon::now())->get();

        return [$allBooking];
    }


    /**
     * show one booking
     * 
     * @return string
     */
    public function show($booking)
    {

        $allBooking = DB::table('bedroom_people')->where('id', $booking->id)
            ->where('start_date', '>=', Carbon::now())->get();

        return $allBooking;
    }



    /**
     * Create a booking
     * 
     * @param User $user who want to create a booking
     * @param array $input The booking data
     * 
     * @return array
     */
    public function store(User $userAuthenticated, array $input): array
    {

        $bedroom = Bedroom::find($input['bedroom_id']);
        $user = User::find($input['user_id']);

        $isAvailability = $bedroom->isAvailability($input['start_date'], $input['end_date']);

        if (!$isAvailability) {
            abort(400, 'You cannot make a booking for this slot');
        }

        if ($userAuthenticated->is_receptionist || $userAuthenticated->is_director) {
            $input['validated'] = 1;
        }

        unset($input['user_id']);

        $input['booker_id'] = $user->people->id;

        $booking = Booking::create($input);

        return [
            'user' => $user,
            'bedroom' => $bedroom->load('showerRoom'),
            'booking' => $booking
        ];
    }

    public function update(Booking $booking, array $input)
    {

        $bedroom = $booking->bedroom;

        if ($booking->validated && isset($input['start_date'], $input['end_date'])) {
            return abort(400, 'You cannot update this booking\'s slot because she is already validated');
        };

        if ($booking->start_date->lessThan(Carbon::now())) {
            abort(400, 'You cannot update a backdated booking');
        }

        $isAvailability = $bedroom->isAvailability($input['start_date'], $input['end_date'], $booking->id);

        if (!$isAvailability) {
            abort(400, 'You cannot make a booking for this slot');
        }

        $booking->update($input);

        return [
            'user' => $booking->people->user,
            'bedroom' => $bedroom->load('showerRoom'),
            'booking' => $booking
        ];
    }
}
