<?php

namespace Rancor\Scanner\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;
use Rancor\Scanner\Models\Entry;

class EntryPolicy
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
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Rancor\Scanner\Models\Entry  $entry
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('view-scanner-entries')
                ? Response::allow()
                : Response::deny('You do not have permissions to view scanner entries.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Rancor\Scanner\Models\Entry  $entry
     * @return mixed
     */
    public function view(User $user, Entry $entry)
    {
        return $user->hasPermission('view-scanner-entries')
                || $entry->contributor->is($user)
                ? Response::allow()
                : Response::deny('You do not have permissions to view this scanner entry.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {    
        return $user->hasPermission('create-scanner-entries')
                ? Response::allow()
                : Response::deny('You do not have permissions to create scanner entries.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function update(User $user, Entry $entry)
    {
        return $user->hasPermission('update-scanner-entries')
                || $entry->contributor->is($user)
                ? Response::allow()
                : Response::deny('You do not have permissions to edit this scanner entry.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function delete(User $user, Entry $entry)
    {
        return $user->hasPermission('delete-scanner-entries')
                ? Response::allow()
                : Response::deny('You do not have permissions to delete this scanner entry.');
    }
}
