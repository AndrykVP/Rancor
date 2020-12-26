<?php

namespace AndrykVP\Rancor\News;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /**
     * Defines the table name
     * 
     * @var string
     */
    protected $table = 'news_articles';

    /**
     * Attributes available for mass assignment
     * 
     * @var array
     */
    protected $fillable = [ 'title', 'body', 'is_published', 'author_id', 'editor_id' ];

    /**
     * Attributes casted to native types
     * 
     * @var array
     */
    protected $casts = [
        'is_published' => 'boolean',
    ];

    /**
     * Defines the table name
     * 
     * @var string
     */
    protected $hidden = ['pivot'];

    /**
     * Relationship to User model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo('App\User','author_id');
    }

    /**
     * Relationship to User model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function editor()
    {
        return $this->belongsTo('App\User','editor_id');
    }

    /**
     * Relationship to Tags model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany('AndrykVP\Rancor\News\Tag','news_article_tag');
    }
}
