<?php

namespace AndrykVP\Rancor\News;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /**
     * Attributes available for mass assignment
     * 
     * @var array
     */
    protected $fillable = [ 'title', 'content', 'is_published' ];

    /**
     * Attributes casted to native types
     * 
     * @var array
     */
    protected $casts = [
        'is_published' => 'boolean',
    ];

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
}
