<?php

namespace AndrykVP\Rancor\Forums\Traits;
use AndrykVP\Rancor\Forums\Models\Board;
use AndrykVP\Rancor\Forums\Models\Category;
use AndrykVP\Rancor\Forums\Models\Discussion;
use AndrykVP\Rancor\Forums\Models\Group;
use AndrykVP\Rancor\Forums\Models\Reply;

trait ForumUser
{
    /**
     * Relationship to Group model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function groups()
    {
        return $this->morphToMany(Group::class,'groupable','forum_groupables')->withTimestamps();
    }

    /**
     * Relationship to Board model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function boards()
    {
        return $this->belongsToMany(Board::class, 'forum_moderators')->withTimestamps();
    }

    /**
     * Relationship to Board model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function unreadDiscussions()
    {
        return $this->belongsToMany(Discussion::class, 'forum_unread_discussions')->whereHas('board', function($query) {
            $query->whereIn('id', $this->topics());
      })->withTimestamps()->orderByDesc('updated_at');
    }

    /**
     * Relationship to Board model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(Reply::class, 'author_id')->latest();
    }

    /**
     * List of IDs from Board model that User has access to
     * 
     * @return array
     */
    public function topics()
    {
        if($this->hasPermission('view-forum-boards'))
        {
            return Board::all()->pluck('id');
        }

        return $this->visibleBoards()->pluck('id')->unique()->sort()->values();
    }

    /**
     * List of IDs from Category model that User has access to
     * 
     * @return array
     */
    public function categories()
    {
        if($this->hasPermission('view-forum-categories'))
        {
            return Category::all()->pluck('id');
        }

        return $this->visibleBoards()->pluck('category_id')->unique()->sort()->values();
    }

    /**
     * Function to retrieve all Boards that the User can see
     * 
     * @return Illuminate\Support\Collection
     */
    private function visibleBoards()
    {
        return $this->groups->pluck('boards')->merge($this->boards)->flatten();
    }
}
