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
    protected $fillable = [ 'name', 'body', 'is_published', 'author_id', 'editor_id', 'published_at' ];

    /**
     * Attributes casted to native types
     * 
     * @var array
     */
    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
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
        return $this->belongsToMany('AndrykVP\Rancor\News\Tag','news_article_tag')->withTimestamps();
    }


    /**
     * Scope a query to include discussions by their is_published status.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query, $value = true)
    {
        return $query->where('is_published', $value);
    }
}
