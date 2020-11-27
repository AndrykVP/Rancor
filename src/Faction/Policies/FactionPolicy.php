<?php

namespace AndrykVP\Rancor\Faction\Policies;

use App\User;
use AndrykVP\Rancor\Faction\Faction;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class FactionPolicy
{
    use HandlesAuthorization;

    /**
     * Bypass policy for Admin users.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function before($user, $ability)
    {
        if ($user->is_admin) {
            return true;
        }
    }

    /**
     * Determine whether the user can view all records of model.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('view-factions')
                ? Response::allow()
                : Response::deny('You do not have permissions to view factions.');
    }
    
    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function view(User $user, Faction $faction)
    {
        return $user->hasPermission('view-factions')
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
        return $user->hasPermission('create-factions')
                ? Response::allow()
                : Response::deny('You do not have permissions to create factions.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function update(User $user, Faction $faction)
    {
        return $user->hasPermission('update-factions')
                ? Response::allow()
                : Response::deny('You do not have permissions to edit this faction.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->hasPermission('delete-factions')
                ? Response::allow()
                : Response::deny('You do not have permissions to delete this faction.');
    }
}
