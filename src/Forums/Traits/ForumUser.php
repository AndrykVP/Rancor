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
        return $this->belongsToMany(Board::class, 'forum_board_user')->withTimestamps();
    }

    /**
     * Relationship to Board model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function unreadDiscussions()
    {
        return $this->belongsToMany(Discussion::class, 'forum_discussion_user')->whereHas('board', function($query) {
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

        return $this->groups->pluck('boards')->flatten()->merge($this->boards)->pluck('id')->unique();
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

        return $this->groups->pluck('categories')->flatten()->pluck('id')->unique();
    }
}
