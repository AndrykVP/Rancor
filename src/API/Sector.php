<?php

namespace AndrykVP\Rancor\API;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    /**
     * Attributes available for mass assignment
     * 
     * @var array
     */
    protected $fillable = [ 'id', 'name'];

    /**
     * Disable auto-increments on 'id' column of the Model
     * 
     * @var boolean
     */
    protected $incrementing = false;

    /**
     * Relationship to System model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function systems()
    {
        return $this->hasMany('AndrykVP\Rancor\API\System');
    }

    /**
     * Relationship to Planet model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function planets()
    {
        return $this->hasManyThrough('AndrykVP\Rancor\API\Planet', 'AndrykVP\Rancor\API\System');
    }
}
