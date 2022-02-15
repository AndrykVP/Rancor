<?php

namespace Rancor\News\Traits;

use Rancor\News\Models\Article;

trait Newscaster
{
    /**
     * Relationship to Article model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function createdArticles()
    {
        return $this->hasMany(Article::class,'id','author_id');
    }

    /**
     * Relationship to Article model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function editedArticles()
    {
        return $this->hasMany(Article::class,'id','editor_id');
    }
}
