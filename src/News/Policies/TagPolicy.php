<?php

namespace AndrykVP\Rancor\News\Policies;

use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use AndrykVP\Rancor\News\Models\Tag;

class TagPolicy
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
        return $user->hasPermission('view-tags')
                ? Response::allow()
                : Response::deny('You do not have permissions to view Tags.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param \AndrykVP\Rncor\News\Tag  $tag
     * @return mixed
     */
    public function view(User $user, Tag $tag)
    {
        return $user->hasPermission('view-tags')
                ? Response::allow()
                : Response::deny('You do not have permissions to view this Tag.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {    
        return $user->hasPermission('create-tags')
                ? Response::allow()
                : Response::deny('You do not have permissions to create Tags.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param \AndrykVP\Rncor\News\Tag  $tag
     * @return mixed
     */
    public function update(User $user, Tag $tag)
    {
        return $user->hasPermission('update-tags')
                ? Response::allow()
                : Response::deny('You do not have permissions to edit this Tag.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param \AndrykVP\Rncor\News\Tag  $tag
     * @return mixed
     */
    public function delete(User $user, Tag $tag)
    {
        return $user->hasPermission('delete-tags')
                ? Response::allow()
                : Response::deny('You do not have permissions to delete this Tag.');
    }
}
