<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->hasPriv('view-users')
                ? Response::allow()
                : Response::deny('You do not have permissions to view users.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->hasPriv('edit-users')
                ? Response::allow()
                : Response::deny('You do not have permissions to edit users.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function uploadArt(User $user)
    {
        return $user->hasPriv('edit-users-art')
                ? Response::allow()
                : Response::deny('You do not have permissions to upload IDs.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function changeRank(User $user)
    {
        return $user->hasPriv('edit-users-rank')
                ? Response::allow()
                : Response::deny('You do not have permissions to change a user\'s faction info.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->hasPriv('delete-users')
                ? Response::allow()
                : Response::deny('You do not have permissions to delete users.');
    }
}
