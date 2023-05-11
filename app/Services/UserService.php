<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\People;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\UploadedFile;

class UserService
{
    /**
     * list a receptionist
     * 
     * @param User $user the Director who create a receptionnist
     * @param array $input The receptionist data
     * 
     * @return array The newly created data of the receptionist
     */
    public function index(User $user, array $input): Paginator
    {

        $hotelId = $user->people->hotel_id;

        $input['hotel_id'] = $hotelId;

        return User::with('people')
            ->where('id', '<>', $user->id)
            ->filter($input)
            ->orderBy('username')
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($user) => [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'avatar_url' => asset($user->avatar),
                'firstname' => $user->people->firstname,
                'lastname' => $user->people->lastname,
                'type' => $user->people->type,
                'created_at' => $user->created_at?->format('Y-m-d')
            ]);
    }

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
        $userData = $input->only(['username', 'email', 'password', 'avatar'])->all();

        $userData['password'] = Hash::make($userData['password']);

        $people = People::create($peopleData);

        $user = $people->user()->create($userData);

        return [
            'people' => $people,
            'account' => $user
        ];
    }


    /**
     * show a user
     * 
     * @param User $user the Director who show a user
     * 
     * @return array
     */
    public function show(User $user): array
    {
        return [
            'people' => $user->people,
            'account' => $user->getAttributes()
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

        if (isset($userData['password'])) {
            if ($userAuthenticated->id !== $userToUpdate->id) {
                abort(401, 'Unauthorized.'); #ToDo: Check if abort function works
            }

            $userData['password'] = Hash::make($userData['password']);
        }

        $userToUpdate->update($userData);

        $userToUpdate->people()->update($peopleData);
    }


    /**
     * Upload user avatar
     * 
     * @param UploadedFile $avatarFile The avatar file
     * 
     * @return array
     */
    public function uploadAvatar(UploadedFile $avatarFile): array
    {

        $avatarPath = $avatarFile->store('users/avatar', 'public');

        return [
            'avatar_path' => $avatarPath,
            'avatar_url' => asset($avatarPath),
        ];
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
