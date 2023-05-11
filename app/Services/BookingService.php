<?php

namespace App\Services;

use App\Models\Bedroom;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\People;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\UploadedFile;

class BookingService
{

    /**
     * Create a booking
     * 
     * @param User $user who want to create a booking
     * @param array $input The booking data
     * 
     * @return array
     */
    public function store(User $userAuthenticated, array $input): void
    {

        $bookerId = $input['booker_id'];

        $bedroom = Bedroom::find($input['bedroom_id']);
        $booker = People::find($bookerId);

        $isAvailability = $bedroom->isAvailability($input['start_date'], $input['start_date']);

        if (!$isAvailability) {
            abort(400, 'You cannot make a booking for this slot');
        }

        unset($input['bedroom_id'], $input['booker_id']);

        if ($userAuthenticated->is_receptionist) {} else {}
    }

}
