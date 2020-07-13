<?php

namespace AndrykVP\Rancor\Faction\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FactionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->hasPriv('view-factions')
                ? Response::allow()
                : Response::deny('You do not have permissions to view factions.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {    
        return $user->hasPriv('create-factions')
                ? Response::allow()
                : Response::deny('You do not have permissions to create factions.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->hasPriv('edit-factions')
                ? Response::allow()
                : Response::deny('You do not have permissions to edit factions.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->hasPriv('delete-factions')
                ? Response::allow()
                : Response::deny('You do not have permissions to delete factions.');
    }
}
