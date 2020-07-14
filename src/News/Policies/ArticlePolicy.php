<?php

namespace AndrykVP\Rancor\News\Policies;

use App\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->hasPermission('view-articles')
                ? Response::allow()
                : Response::deny('You do not have permissions to view articles.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {    
        return $user->hasPermission('create-articles')
                ? Response::allow()
                : Response::deny('You do not have permissions to create articles.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->hasPermission('edit-articles')
                ? Response::allow()
                : Response::deny('You do not have permissions to edit articles.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->hasPermission('delete-articles')
                ? Response::allow()
                : Response::deny('You do not have permissions to delete articles.');
    }
}
