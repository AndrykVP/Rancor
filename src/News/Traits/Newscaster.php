<?php

namespace AndrykVP\Rancor\News\Traits;

trait Newscaster
{
    /**
     * Relationship to Article model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function createdArticles()
    {
        return $this->hasMany('AndrykVP\Rancor\News\Article','id','author_id');
    }

    /**
     * Relationship to Article model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function editedArticles()
    {
        return $this->hasMany('AndrykVP\Rancor\News\Article','id','editor_id');
    }
}
