<?php

namespace AndrykVP\Rancor\Holocron;

use Illuminate\Database\Eloquent\Model;

class Node extends Model
{
    /**
     * Defines the table name
     * 
     * @var string
     */
    protected $table = 'holocron_nodes';

    /**
     * Attributes available for mass assignment
     * 
     * @var array
     */
    protected $fillable = [ 'name', 'body', 'is_published', 'is_private', 'author_id', 'editor_id', 'published_at' ];

    /**
     * Attributes casted to native types
     * 
     * @var array
     */
    protected $casts = [
        'is_published' => 'boolean',
        'is_private' => 'boolean',
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
     * Relationship to Collection model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function collections()
    {
        return $this->belongsToMany('AndrykVP\Rancor\Holocron\Collections','holocron_collection_node')->withTimestamps();
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


    /**
     * Scope a query to include discussions by their is_private status.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePrivate($query, $value = true)
    {
        return $query->where('is_private', $value);
    }
}
