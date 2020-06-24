<?php

namespace AndrykVP\SWC\Models;

use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    /**
     * Attributes available for mass assignment
     * 
     * @var array
     */
    protected $fillable = [ 'id' ];
    
    /**
     * Disable auto-increments on 'id' column of the Model
     * 
     * @var boolean
     */
    protected $incrementing = false;

    /**
     * Relationship to Planet model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function planets()
    {
        return $this->hasMany('AndrykVP\SWC\Models\Planet');
    }

    /**
     * Relationship to Sector model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sector()
    {
        return $this->belongsTo('AndrykVP\SWC\Models\Sector');
    }
}
