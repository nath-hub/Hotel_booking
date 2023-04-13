<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;
use App\Models\User;
use App\Models\People;

class ReceptionistService
{

    /**
     * Create a receptionist
     * 
     * @param User $user the Director who create a receptionnist
     * @param array $input The receptionist data
     * 
     * @return array The newly created data of the receptionist
     */
    public function store(User $user, array $input): array
    {

        $input = collect($input)->merge([
            'type' => 'RECEPTIONIST',
            'hotel_id' => $user->people->hotel_id
        ]);

        $receptionistData = $input->only(['firstname', 'lastname', 'type', 'hotel_id'])->all();
        $userData = $input->only(['username', 'email', 'password', 'avatar_path'])->all();

        $userData['password'] = Hash::make($userData['password']);

        $people = People::create($receptionistData);

        $user = $people->user()->create($userData);

        return [
            'receptionist' => $people->toArray(),
            'account' => $user->toArray()
        ];
    }
}
