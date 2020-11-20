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
     * Relationship to Categories model through Group model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\Collection
     */
    public function getCategoryIDs()
    {
        if($this->hasPermission('view-forum-categories'))
        {
            return Category::all()->pluck('id')->toArray();
        }
        return $this->groups->pluck('categories')->collapse()->pluck('id')->toArray();
    }
}
