<?php

namespace AndrykVP\Rancor\Holocron\Policies;

use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use AndrykVP\Rancor\Holocron\Models\Collection;

class CollectionPolicy
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
        return $user->hasPermission('view-holocron-collections')
                ? Response::allow()
                : Response::deny('You do not have permissions to view holocron collections.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param \AndrykVP\Rncor\Holocron\Collection  $collection
     * @return mixed
     */
    public function view(User $user, Collection $collection)
    {
        return $user->hasPermission('view-holocron-collections')
                ? Response::allow()
                : Response::deny('You do not have permissions to view this holocron collection.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {    
        return $user->hasPermission('create-holocron-collections')
                ? Response::allow()
                : Response::deny('You do not have permissions to create holocron collections.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param \AndrykVP\Rncor\Holocron\Collection  $Collection
     * @return mixed
     */
    public function update(User $user, Collection $Collection)
    {
        return $user->hasPermission('update-holocron-collections')
                ? Response::allow()
                : Response::deny('You do not have permissions to edit this holocron collection.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param \AndrykVP\Rncor\Holocron\Collection  $Collection
     * @return mixed
     */
    public function delete(User $user, Collection $Collection)
    {
        return $user->hasPermission('delete-holocron-collections')
                ? Response::allow()
                : Response::deny('You do not have permissions to delete this holocron collection.');
    }
}
