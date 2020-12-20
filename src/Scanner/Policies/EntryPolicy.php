<?php

namespace AndrykVP\Rancor\Scanner\Policies;

use App\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;
use AndrykVP\Rancor\Scanner\Entry;

class EntryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \AndrykVP\Rancor\Scanner\Entry  $entry
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->is_admin
                || $user->hasPermission('view-scans')
                ? Response::allow()
                : Response::deny('You do not have permissions to view scanner entries.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \AndrykVP\Rancor\Scanner\Entry  $entry
     * @return mixed
     */
    public function view(User $user, Entry $entry)
    {
        return $user->is_admin
                || $user->hasPermission('view-scans')
                || $entry->updated_by === $user->id
                ? Response::allow()
                : Response::deny('You do not have permissions to view this scanner entry.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {    
        return $user->is_admin
                || $user->hasPermission('create-scans')
                ? Response::allow()
                : Response::deny('You do not have permissions to create scanner entries.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function update(User $user, Entry $entry)
    {
        return $user->is_admin
                || $user->hasPermission('edit-scans')
                || $entry->updated_by === $user->id
                ? Response::allow()
                : Response::deny('You do not have permissions to edit this scanner entry.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function delete(User $user, Entry $entry)
    {
        return $user->is_admin
                || $user->hasPermission('delete-scans')
                ? Response::allow()
                : Response::deny('You do not have permissions to delete this scanner entry.');
    }
}
