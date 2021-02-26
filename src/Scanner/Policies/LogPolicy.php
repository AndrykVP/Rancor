<?php

namespace AndrykVP\Rancor\Scanner\Policies;

use App\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class LogPolicy
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
        return $user->hasPermission('view-scanlogs')
                ? Response::allow()
                : Response::deny('You do not have permissions to view scanner logs.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->hasPermission('delete-scanlogs')
                ? Response::allow()
                : Response::deny('You do not have permissions to delete scanner logs.');
    }
}
