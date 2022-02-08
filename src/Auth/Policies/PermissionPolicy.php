<?php

namespace AndrykVP\Rancor\Auth\Policies;

use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;
use AndrykVP\Rancor\Auth\Models\Permission;
use App\Models\User;

class PermissionPolicy
{
    use HandlesAuthorization;

    public function before(User $user, String $ability): bool
    {
        if($user->is_banned) return false;
        if($user->is_admin) return true;
    }

    public function viewAny(User $user): Response
    {
        return $user->hasPermission('view-permissions')
                ? Response::allow()
                : Response::deny('You do not have permissions to view permissions.');
    }

    public function view(User $user, Permission $permission): Response
    {
        return $user->hasPermission('view-permissions')
                ? Response::allow()
                : Response::deny('You do not have permissions to view this permission.');
    }

    public function create(User $user): Response
    {    
        return $user->hasPermission('create-permissions')
                ? Response::allow()
                : Response::deny('You do not have permissions to create permissions.');
    }

    public function update(User $user, Permission $permission): Response
    {
        return $user->hasPermission('update-permissions')
                ? Response::allow()
                : Response::deny('You do not have permissions to edit this permission.');
    }

    public function delete(User $user, Permission $permission): Response
    {
        return $user->hasPermission('delete-permissions')
                ? Response::allow()
                : Response::deny('You do not have permissions to delete this permission.');
    }
}
