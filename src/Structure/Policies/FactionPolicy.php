<?php

namespace Rancor\Structure\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;
use Rancor\Structure\Models\Faction;

class FactionPolicy
{
    use HandlesAuthorization;

    /**
     * Bypass policy for Admin users.
     *
     * @param  \App\Models\User  $user
     * @param  string  $ability
     * @return void|bool
     */
    public function before(User $user, $ability)
    {
        if($user->is_banned) return false;
        if($user->is_admin) return true;
    }

    /**
     * Determine whether the user can view all records of model.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('view-structure-factions')
                ? Response::allow()
                : Response::deny('You do not have permissions to view factions.');
    }
    
    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function view(User $user, Faction $faction)
    {
        return $user->hasPermission('view-structure-factions')
                ? Response::allow()
                : Response::deny('You do not have permissions to view this faction.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {    
        return $user->hasPermission('create-structure-factions')
                ? Response::allow()
                : Response::deny('You do not have permissions to create factions.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function update(User $user, Faction $faction)
    {
        return $user->hasPermission('update-structure-factions')
                ? Response::allow()
                : Response::deny('You do not have permissions to edit this faction.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function delete(User $user, Faction $faction)
    {
        return $user->hasPermission('delete-structure-factions')
                ? Response::allow()
                : Response::deny('You do not have permissions to delete this faction.');
    }
}
