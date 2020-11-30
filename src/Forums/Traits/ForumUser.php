<?php

namespace AndrykVP\Rancor\Forums\Traits;
use AndrykVP\Rancor\Forums\Category;

trait ForumUser
{
    /**
     * Relationship to Group model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function groups()
    {
        return $this->belongsToMany('AndrykVP\Rancor\Forums\Group','forum_group_user')->withTimestamps();
    }

    /**
     * Relationship to Board model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function boards()
    {
        return $this->belongsToMany('AndrykVP\Rancor\Forums\Board', 'forum_board_user')->withTimestamps();
    }

    /**
     * Relationship to Board model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function unreadDiscussions()
    {
        return $this->belongsToMany('AndrykVP\Rancor\Forums\Discussion', 'forum_discussion_user')->whereHas('board', function($query) {
            $query->whereIn('category_id', $this->getCategoryIDs());
      })->withTimestamps()->orderByDesc('updated_at');
    }

    /**
     * Relationship to Board model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany('AndrykVP\Rancor\Forums\Reply', 'author_id');
    }

    /**
     * List of IDs from Category Model that User has access to
     * 
     * @return array
     */
    public function getCategoryIDs()
    {
        $cacheKey = `USER.{$this->id}.CATEGORIES`;
        $timeLimit = now()->addMinutes(15);

        if($this->hasPermission('view-forum-categories'))
        {
            return cache()->remember($cacheKey, $timeLimit, function() {
                return Category::all()->pluck('id')->toArray();
            });
        }

        return cache()->remember($cacheKey, $timeLimit, function() {
            return $this->groups->pluck('categories')->collapse()->pluck('id')->toArray();
        });
    }
}
