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
     * @param  string  $ability
     * @return void|bool
     */
    public function before(User $user, $ability)
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
        return $user->hasPermission('view-news-articles')
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
                ||$article->author->is($user)
                ||$article->editor->is($user)
                ||$user->hasPermission('view-news-articles')
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
        return $user->hasPermission('create-news-articles')
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
        return $article->author->is($user)
                ||$user->hasPermission('update-news-articles')
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
        return $user->hasPermission('delete-news-articles')
                ? Response::allow()
                : Response::deny('You do not have permissions to delete this article.');
    }
}
