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
        return $this->belongsToMany('AndrykVP\Rancor\Forums\Group','forum_group_user');
    }

    /**
     * Relationship to Board model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function boards()
    {
        return $this->belongsToMany('AndrykVP\Rancor\Forums\Board', 'forum_board_user');
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
     * Relationship to Categories model through Group model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\Collection
     */
    public function getCategoryIDs()
    {
        $cacheKey = `USER.{$this->id}.CATEGORIES`;
        $timeLimit = now()->addMinutes(5);

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
