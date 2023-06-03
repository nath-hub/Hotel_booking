<?php

namespace App\Services;

use App\Models\Bedroom;
use App\Models\Booking;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\Paginator;

class BookingService
{

    /**
     * Returns a paginated list of bookings based on critria
     * 
     * @param User $user want to display the list
     * @param array $input The filter data
     * 
     * @return Paginator a paginate list of booking
     */
    public function index(User $user, array $input): Paginator
    {

        $hotelId = $user->people->hotel_id;

        $input['hotel_id'] = $hotelId;

        if ($user->is_booker) {
            $input['user_id'] = $user->id;
        }

        return Booking::with(['people.user', 'bedroom.showerRoom'])
            ->filter($input)
            ->orderBy('start_date')
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($booking) => [
                'booking' => $booking->getAttributes(),
                'user' => $booking->people->user,
                'booker' => $booking->people->getAttributes(),
                'bedroom' => $booking->bedroom->getAttributes(),
                'shower_room' => $booking->bedroom->showerRoom,
            ]);
    }


    /**
     * show booking information
     * 
     * @return array
     */
    public function show($booking)
    {

        $booking->load(['people.user', 'bedroom.showerRoom', 'companions']);

        return [
            'booking' => $booking->getAttributes(),
            'user' => $booking->people->user,
            'booker' => $booking->people->getAttributes(),
            'bedroom' => $booking->bedroom->getAttributes(),
            'shower_room' => $booking->bedroom->showerRoom,
            'companions' => $booking->companions
        ];
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
