<?php

namespace AndrykVP\Rancor\Holocron\Traits;

trait HoloRecorder
{
    /**
     * Relationship to Node model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function createdNodes()
    {
        return $this->hasMany('AndrykVP\Rancor\Holocron\Node','id','author_id');
    }

    /**
     * Relationship to Node model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function editedNodes()
    {
        return $this->hasMany('AndrykVP\Rancor\Holocron\Node','id','editor_id');
    }
}
