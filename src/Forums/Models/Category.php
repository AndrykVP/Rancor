<?php

namespace AndrykVP\Rancor\Forums\Models;

use Illuminate\Database\Eloquent\Model;
use AndrykVP\Database\Factories\CategoryFactory;

class Category extends Model
{
    /**
     * Defines the table name
     * 
     * @var string
     */
    protected $table = 'forum_categories';
    
    /**
     * Attributes available for mass assignment
     * 
     * @var array
     */
    protected $fillable = [ 'name', 'description', 'color', 'slug', 'order' ];

    /**
     * Relationship to Board model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function boards()
    {
        return $this->hasMany('AndrykVP\Rancor\Forums\Board')->orderBy('order');
    }

    /**
     * Relationship to Board model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function discussions()
    {
        return $this->hasManyThrough('AndrykVP\Rancor\Forums\Discussion','AndrykVP\Rancor\Forums\Board');
    }

    /**
     * Relationship to Group model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups()
    {
        return $this->morphToMany('AndrykVP\Rancor\Forums\Group','groupable','forum_groupables')->withTimestamps();
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return CategoryFactory::new();
    }
}
