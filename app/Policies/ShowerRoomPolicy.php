<?php

namespace App\Policies;

use App\Models\ShowerRoom;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ShowerRoomPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user):bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ShowerRoom $showerRoom):bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->people->type == "DIRECTOR";
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ShowerRoom $showerRoom)
    {
        return $user->people->type == "DIRECTOR";
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ShowerRoom $showerRoom)
    {
        return $user->people->type == "DIRECTOR";
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ShowerRoom $showerRoom)
    {
        return $user->people->type == "DIRECTOR";
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ShowerRoom $showerRoom)
    {
        return $user->people->type == "SUPERADMIN";
    }
}
