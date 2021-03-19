<?php

namespace AndrykVP\Rancor\Structure\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;
use AndrykVP\Rancor\Structure\Models\Department;

class DepartmentPolicy
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
     * Determine whether the user can view all records of model.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('view-structure-departments')
                ? Response::allow()
                : Response::deny('You do not have permissions to view departments.');
    }
    
    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param \AndrykVP\Rancor\Structure\Models\Department  $department
     * @return mixed
     */
    public function view(User $user, Department $department)
    {
        return $user->hasPermission('view-structure-departments')
                ? Response::allow()
                : Response::deny('You do not have permissions to view this department.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {    
        return $user->hasPermission('create-structure-departments')
                ? Response::allow()
                : Response::deny('You do not have permissions to create departments.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param \AndrykVP\Rancor\Structure\Models\Department  $department
     * @return mixed
     */
    public function update(User $user, Department $department)
    {
        return $user->hasPermission('update-structure-departments')
                ? Response::allow()
                : Response::deny('You do not have permissions to edit this department.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param \AndrykVP\Rancor\Structure\Models\Department  $department
     * @return mixed
     */
    public function delete(User $user, Department $department)
    {
        return $user->hasPermission('delete-structure-departments')
                ? Response::allow()
                : Response::deny('You do not have permissions to delete this department.');
    }
}
