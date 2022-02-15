<?php

namespace Rancor\Forums\Policies;

use App\Models\User;
use Rancor\Forums\Models\Group;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupPolicy
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
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('view-forum-groups')
                ? Response::allow()
                : Response::deny('You do not have permissions to view forum groups.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Rancor\Forums\Models\Group  $group
     * @return mixed
     */
    public function view(User $user, Group $group)
    {
        return $user->hasPermission('view-forum-groups')
                ? Response::allow()
                : Response::deny('You do not have permissions to view this forum group.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('create-forum-groups')
                ? Response::allow()
                : Response::deny('You do not have permissions to create forum groups.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Rancor\Forums\Models\Group  $group
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->hasPermission('update-forum-groups')
                ? Response::allow()
                : Response::deny('You do not have permissions to update this forum group.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \Rancor\Forums\Models\Group  $group
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->hasPermission('delete-forum-groups')
                ? Response::allow()
                : Response::deny('You do not have permissions to delete this forum group.');
    }
}
