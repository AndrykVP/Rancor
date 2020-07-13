<?php

namespace AndrykVP\Rancor\Faction\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RankPolicy
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
        return $user->hasPriv('view-ranks')
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
        return $user->hasPriv('create-ranks')
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
        return $user->hasPriv('edit-ranks')
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
        return $user->hasPriv('delete-ranks')
                ? Response::allow()
                : Response::deny('You do not have permissions to delete ranks.');
    }
}
