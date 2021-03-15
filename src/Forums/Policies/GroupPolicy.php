<?php

namespace AndrykVP\Rancor\Forums\Policies;

use App\Models\User;
use AndrykVP\Rancor\Forums\Models\Group;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupPolicy
{
    use HandlesAuthorization;

    /**
     * Bypass policy for Admin users.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function before($user, $ability)
    {
        if ($user->is_admin) {
            return true;
        }
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
                : Response::deny('You do not have Permissions to View Forum Groups.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \AndrykVP\Rancor\Forums\Models\Group  $group
     * @return mixed
     */
    public function view(User $user, Group $group)
    {
        return $user->hasPermission('view-forum-groups')
                ? Response::allow()
                : Response::deny('You do not have Permissions to View this Forum Group.');
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
                : Response::deny('You do not have Permissions to Create Forum Groups.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \AndrykVP\Rancor\Forums\Models\Group  $group
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->hasPermission('update-forum-groups')
                ? Response::allow()
                : Response::deny('You do not have Permissions to Update this Forum Group.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \AndrykVP\Rancor\Forums\Models\Group  $group
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->hasPermission('delete-forum-groups')
                ? Response::allow()
                : Response::deny('You do not have Permissions to Delete this Forum Group.');
    }
}
