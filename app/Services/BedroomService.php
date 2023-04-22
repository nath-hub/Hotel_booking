<?php

namespace App\Services;

use App\Models\Bedroom;
use Illuminate\Support\Collection;
use App\Models\User;
use App\Models\ShowerRoom;

class BedroomService
{

    /**
     * Create a bedroom
     * 
     * @param User $user the Director who create a bedroom
     * @param array $input The bedroom data
     * 
     * @return array The newly created data of the bedroom
     */
    public function store(User $user, array $input): array
    {

        $input['hotel_id'] = $user->people->hotel_id;

        $input = collect($input);

        $bedroomData = $input->only(['code', 'bed_number', 'price', 'hotel_id'])->all();
        $showerRoomData = $input->only(['type'])->all();

        $bedroom = Bedroom::create($bedroomData);

        $showerRoom = $bedroom->showerRoom()->create($showerRoomData);

        return [
            'shower_room' => $showerRoom,
            'bedroom' => $bedroom
        ];
    }

    
}
