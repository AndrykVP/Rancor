<?php

namespace AndrykVP\Rancor\Holocron;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Auth;

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
    protected $fillable = [ 'name', 'body', 'is_public', 'author_id', 'editor_id' ];

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
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('access', function (Builder $builder) {
            if(Auth::check() && Auth::user()->can('viewAny', Node::class))
            {
                $builder;
            }
            else
            {
                $builder->where('is_public', true);
            }
        });
    }

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
        return $this->belongsToMany('AndrykVP\Rancor\Holocron\Collection','holocron_collection_node')->withTimestamps();
    }
}
