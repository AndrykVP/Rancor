<?php

namespace AndrykVP\Rancor\Forums\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use AndrykVP\Rancor\Database\Factories\CategoryFactory;

class Category extends Model
{
    use HasFactory;
    
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
    protected $fillable = [ 'name', 'description', 'color', 'slug', 'lineup' ];

    /**
     * Relationship to Board model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function boards()
    {
        return $this->hasMany(Board::class)->orderBy('lineup');
    }

    /**
     * Relationship to Board model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function discussions()
    {
        return $this->hasManyThrough(Discussion::class, Board::class);
    }

    /**
     * Relationship to Group model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups()
    {
        return $this->morphToMany(Group::class, 'groupable', 'forum_groupables')->withTimestamps();
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
