<?php

namespace AndrykVP\Rancor\Forums\Traits;
use AndrykVP\Rancor\Forums\Category;

trait ForumGroups
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
     * Relationship to Categories model through Group model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\Collection
     */
    public function getCategoryIDs()
    {
        return $this->groups->pluck('categories')->collapse()->pluck('id')->toArray();
    }
}
