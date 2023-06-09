<?php

namespace App\Policies;

use App\Models\Bedroom;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BedroomPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function index(User $user)
    {
        #ToDo: See what we need to do later
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function show(?User $user, Bedroom $bedroom)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->is_director;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user)
    {
        return $user->is_director;
    }

        /**
     * check if an user can upload a file
     */
    public function uploadFileBedroom(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Bedroom $bedroom)
    {
        return $user->is_director;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Bedroom $bedroom)
    {
        return $user->is_director;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Bedroom $bedroom)
    {
        //
    }
}
