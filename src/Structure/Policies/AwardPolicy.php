<?php

namespace AndrykVP\Rancor\Structure\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;
use AndrykVP\Rancor\Structure\Models\Award;

class AwardPolicy
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
        return $user->hasPermission('view-structure-awards')
                ? Response::allow()
                : Response::deny('You do not have permissions to view awards.');
    }
    
    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param \AndrykVP\Rancor\Structure\Models\Award  $award
     * @return mixed
     */
    public function view(User $user, Award $award)
    {
        return $user->hasPermission('view-structure-awards')
                ? Response::allow()
                : Response::deny('You do not have permissions to view this award.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {    
        return $user->hasPermission('create-structure-awards')
                ? Response::allow()
                : Response::deny('You do not have permissions to create awards.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param \AndrykVP\Rancor\Structure\Models\Award  $award
     * @return mixed
     */
    public function update(User $user, Award $award)
    {
        return $user->hasPermission('update-structure-awards')
                ? Response::allow()
                : Response::deny('You do not have permissions to edit awards.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param \AndrykVP\Rancor\Structure\Models\Award  $award
     * @return mixed
     */
    public function delete(User $user, Award $award)
    {
        return $user->hasPermission('delete-structure-awards')
                ? Response::allow()
                : Response::deny('You do not have permissions to delete awards.');
    }


    /**
     * Determine whether the user can update the model relationship.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function giveAward(User $user, User $model)
    {
        return $user->hasPermission('grant-structure-awards')
                && $model->rank_id != null
                ? Response::allow()
                : Response::deny('You do not have permissions to delete awards.');
    }


    /**
     * Determine whether the user can update the model relationship.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function removeAward(User $user, User $model)
    {
        return $user->hasPermission('remove-structure-awards')
                ? Response::allow()
                : Response::deny('You do not have permissions to delete awards.');
    }
}
