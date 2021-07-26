<?php

namespace AndrykVP\Rancor\News\Policies;

use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use AndrykVP\Rancor\News\Models\Article;

class ArticlePolicy
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
        return $user->hasPermission('view-articles')
                ? Response::allow()
                : Response::deny('You do not have permissions to view articles.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param \AndrykVP\Rncor\News\Article  $article
     * @return mixed
     */
    public function view(?User $user, Article $article)
    {
        return $article->is_published
                ||$user->is($article->author)
                ||$user->is($article->editor)
                ||$user->hasPermission('view-articles')
                ? Response::allow()
                : Response::deny('You do not have permissions to view this article.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
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
     * @param  \App\Models\User  $user
     * @param \AndrykVP\Rncor\News\Article  $article
     * @return mixed
     */
    public function update(User $user, Article $article)
    {
        return $user->is($article->author)
                ||$user->hasPermission('update-articles')
                ? Response::allow()
                : Response::deny('You do not have permissions to edit this article.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param \AndrykVP\Rncor\News\Article  $article
     * @return mixed
     */
    public function delete(User $user, Article $article)
    {
        return $user->hasPermission('delete-articles')
                ? Response::allow()
                : Response::deny('You do not have permissions to delete this article.');
    }
}
