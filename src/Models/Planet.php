<?php

namespace AndrykVP\SWC\Models;

use Illuminate\Database\Eloquent\Model;

class Planet extends Model
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
     * Relationship to System model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function system()
    {
        return $this->belongsTo(System::class);
    }
}
