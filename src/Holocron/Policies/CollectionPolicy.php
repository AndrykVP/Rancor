<?php

namespace AndrykVP\Rancor\Holocron\Policies;

use App\User;
use AndrykVP\Rancor\Holocron\Collection;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class CollectionPolicy
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
        return Response::allow();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param \AndrykVP\Rncor\News\Collection  $Collection
     * @return mixed
     */
    public function view(User $user, Collection $Collection)
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {    
        return $user->hasPermission('create-holocron-collections')
                ? Response::allow()
                : Response::deny('You do not have permissions to create Collections.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param \AndrykVP\Rncor\News\Collection  $Collection
     * @return mixed
     */
    public function update(User $user, Collection $Collection)
    {
        return $user->hasPermission('update-holocron-collections')
                ? Response::allow()
                : Response::deny('You do not have permissions to edit this Collection.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param \AndrykVP\Rncor\News\Collection  $Collection
     * @return mixed
     */
    public function delete(User $user, Collection $Collection)
    {
        return $user->hasPermission('delete-holocron-collections')
                ? Response::allow()
                : Response::deny('You do not have permissions to delete this Collection.');
    }
}
