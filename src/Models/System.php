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
    public $fillable = [ 'id' ];
    
    /**
     * Disable auto-increments on 'id' column of the Model
     * 
     * @var boolean
     */
    public $incrementing = false;

    /**
     * Relationship to Planet model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function planets()
    {
        return $this->hasMany(Planet::class);
    }

    /**
     * Relationship to System model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function system()
    {
        return $this->belongsTo(System::class);
    }
}
