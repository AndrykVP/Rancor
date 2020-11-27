<?php

namespace AndrykVP\Rancor\Faction\Policies;

use App\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class RankPolicy
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
     * Determine whether the user can view all records model.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('view-ranks')
                ? Response::allow()
                : Response::deny('You do not have permissions to view ranks.');
    }
    
    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->hasPermission('view-ranks')
                ? Response::allow()
                : Response::deny('You do not have permissions to view ranks.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {    
        return $user->hasPermission('create-ranks')
                ? Response::allow()
                : Response::deny('You do not have permissions to create ranks.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->hasPermission('update-ranks')
                ? Response::allow()
                : Response::deny('You do not have permissions to edit ranks.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->hasPermission('delete-ranks')
                ? Response::allow()
                : Response::deny('You do not have permissions to delete ranks.');
    }
}
