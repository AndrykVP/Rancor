<?php

namespace AndrykVP\Rancor\Holocron\Models;

use Illuminate\Database\Eloquent\Model;
use AndrykVP\Rancor\Database\Factories\CollectionFactory;

class Collection extends Model
{
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return CollectionFactory::new();
    }
    
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