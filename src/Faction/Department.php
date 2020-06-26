<?php

namespace AndrykVP\SWC\Faction;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    /**
     * Attributes available for mass assignment
     * 
     * @var array
     */
    protected $fillable = [ 'name', 'description', 'faction_id' ];

    /**
     * Relationship to Rank model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ranks()
    {
        return $this->hasMany('AndrykVP\SWC\Faction\Rank');
    }

    /**
     * Relationship to User model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function users()
    {
        return $this->hasManyThrough('App\User', 'AndrykVP\SWC\Faction\Rank');
    }

    /**
     * Relationship to Faction model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function faction()
    {
        return $this->belongsTo('AndrykVP\SWC\Faction\Faction');
    }
}
