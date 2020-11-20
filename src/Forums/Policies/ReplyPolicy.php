<?php

namespace AndrykVP\Rancor\Forums\Policies;

use App\User;
use AndrykVP\Rancor\Forums\Reply;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('view-forum-replies')
                ? Response::allow()
                : Response::deny('You do not have Permissions to View Forum Replies.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \AndrykVP\Rancor\Forums\Reply  $reply
     * @return mixed
     */
    public function view(User $user, Reply $reply)
    {
        $categoryIDs = $user->getCategoryIDs();

        return $reply->author_id == $user->id || in_array($reply->discussion->board->category_id,$categoryIDs)
                ? Response::allow()
                : Response::deny('You do not have Permissions to View this Forum Reply.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('create-forum-replies')
                ? Response::allow()
                : Response::deny('You do not have Permissions to Create Forum Replies.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \AndrykVP\Rancor\Forums\Reply  $reply
     * @return mixed
     */
    public function update(User $user, Reply $reply)
    {
        return ( $user->hasPermission('update-forum-replies')
                || $reply->author_id == $user->id
                || $reply->discussion->board->moderators->contains($user) )
                ? Response::allow()
                : Response::deny('You do not have Permissions to Update this Forum Reply.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \AndrykVP\Rancor\Forums\Reply  $reply
     * @return mixed
     */
    public function delete(User $user, Reply $reply)
    {
        return $user->hasPermission('delete-forum-replies')
                || $reply->discussion->board->moderators->contains($user)
                ? Response::allow()
                : Response::deny('You do not have Permissions to Delete this Forum Reply.');
    }
}
