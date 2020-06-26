<?php

namespace AndrykVP\SWC\Faction;

use Illuminate\Database\Eloquent\Model;

class Faction extends Model
{
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
        return $this->hasMany('AndrykVP\SWC\Faction\Department');
    }

    /**
     * Relationship to Rank model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function ranks()
    {
        return $this->hasManyThrough('AndrykVP\SWC\Faction\Rank', 'AndrykVP\SWC\Faction\Department');
    }
}
