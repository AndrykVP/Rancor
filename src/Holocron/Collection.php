<?php

namespace AndrykVP\Rancor\Holocron;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    /**
     * Defines the table name
     * 
     * @var string
     */
    protected $table = 'holocron_collections';

    /**
     * Attributes available for mass assignment
     * 
     * @var array
     */
    protected $fillable = [ 'name', 'slug', 'description' ];

    /**
     * Defines the table name
     * 
     * @var string
     */
    protected $hidden = ['pivot'];

    /**
     * Relationship to Node model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function nodes()
    {
        return $this->belongsToMany('AndrykVP\Rancor\Holocron\Node','holocron_collection_node')->withTimestamps();
    }
}
