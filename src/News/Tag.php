<?php

namespace AndrykVP\Rancor\News;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * Defines the table name
     * 
     * @var string
     */
    protected $table = 'news_tags';

    /**
     * Attributes available for mass assignment
     * 
     * @var array
     */
    protected $fillable = [ 'name', 'color' ];

    /**
     * Defines the table name
     * 
     * @var string
     */
    protected $hidden = ['pivot'];

    /**
     * Relationship to Tags model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function articles()
    {
        return $this->belongsToMany('AndrykVP\Rancor\News\Article','news_article_tag');
    }
}
