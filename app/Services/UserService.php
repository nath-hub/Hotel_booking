<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;
use App\Models\User;
use App\Models\People;

class UserService
{

    /**
     * Create a receptionist
     * 
     * @param User $user the Director who create a receptionnist
     * @param array $input The receptionist data
     * 
     * @return array The newly created data of the receptionist
     */
    public function store(?User $user, array $input): array
    {

        $input = collect($input)->merge([
            'hotel_id' => $user?->people->hotel_id
        ]);

        $peopleData = $input->only(['firstname', 'lastname', 'type', 'hotel_id'])->all();
        $userData = $input->only(['username', 'email', 'password', 'avatar_path'])->all();

        $userData['password'] = Hash::make($userData['password']);

        $people = People::create($peopleData);

        $user = $people->user()->create($userData);

        return [
            'people' => $people,
            'account' => $user
        ];
    }

    /**
     * Update a receptionist
     * 
     * @param User $user the a receptionnist who updates his data
     * @param array $input The receptionist data
     * 
     * @return void
     */
    public function update(User $userAuthenticated, User $userToUpdate, array $input): void
    {

        $input = collect($input);

        $peopleData = $input->except(['username', 'email', 'password', 'avatar_path'])->all();
        $userData = $input->except(['firstname', 'lastname'])->all();

        if (isset($userData['password']) && ($userAuthenticated->id === $userToUpdate->id)) {
            $userData['password'] = Hash::make($userData['password']);
        } elseif (isset($userData['password']) && ($userAuthenticated->id !== $userToUpdate->id)) {
            dd('error');
        }

        $userToUpdate->update($userData);

        $userToUpdate->people()->update($peopleData);
    }



     /**
     * Delete a receptionist
     * 
     * @param User $user a director who delete a receptionist
     * @param array $input The receptionist id
     * 
     * @return void
     */
    public function delete(User $userAuthenticated, User $userToDelete)
    {
        $userToDelete->delete();
        $userToDelete->people()->delete();
    }

}
