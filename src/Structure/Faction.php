<?php

namespace AndrykVP\Rancor\Structure;

use Illuminate\Database\Eloquent\Model;

class Faction extends Model
{
    /**
     * Defines the table name
     * 
     * @var string
     */
    protected $table = 'structure_factions';

    /**
     * Attributes available for mass assignment
     * 
     * @var array
     */
    protected $fillable = [ 'name' ];

    /**
     * Relationship to Department model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function departments()
    {
        return $this->hasMany('AndrykVP\Rancor\Structure\Department');
    }

    /**
     * Relationship to Rank model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function ranks()
    {
        return $this->hasManyThrough('AndrykVP\Rancor\Structure\Rank', 'AndrykVP\Rancor\Structure\Department');
    }
}
