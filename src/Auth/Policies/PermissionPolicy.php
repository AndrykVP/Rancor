<?php

namespace Rancor\Auth\Policies;

use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;
<<<<<<< HEAD
use Rancor\Auth\Models\Permission;
=======
use AndrykVP\Rancor\Auth\Models\Permission;
use App\Models\User;
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6

class PermissionPolicy
{
	use HandlesAuthorization;

<<<<<<< HEAD
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
		return $user->hasPermission('view-permissions')
				? Response::allow()
				: Response::deny('You do not have permissions to view permissions.');
	}

	/**
	 * Determine whether the user can view the model.
	 *
	 * @param  \App\Models\User  $user
	 * @param \Rancor\Auth\Models\Permission  $permission
	 * @return mixed
	 */
	public function view(User $user, Permission $permission)
	{
		return $user->hasPermission('view-permissions')
				? Response::allow()
				: Response::deny('You do not have permissions to view this permission.');
	}

	/**
	 * Determine whether the user can create models.
	 *
	 * @param  \App\Models\User  $user
	 * @return mixed
	 */
	public function create(User $user)
	{    
		return $user->hasPermission('create-permissions')
				? Response::allow()
				: Response::deny('You do not have permissions to create permissions.');
	}

	/**
	 * Determine whether the user can update the model.
	 *
	 * @param  \App\Models\User  $user
	 * @param \Rancor\Auth\Models\Permission  $permission
	 * @return mixed
	 */
	public function update(User $user, Permission $permission)
	{
		return $user->hasPermission('update-permissions')
				? Response::allow()
				: Response::deny('You do not have permissions to edit this permission.');
	}

	/**
	 * Determine whether the user can delete the model.
	 *
	 * @param  \App\Models\User  $user
	 * @param \Rancor\Auth\Models\Permission  $permission
	 * @return mixed
	 */
	public function delete(User $user, Permission $permission)
	{
		return $user->hasPermission('delete-permissions')
				? Response::allow()
				: Response::deny('You do not have permissions to delete this permission.');
	}
=======
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
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6
}
