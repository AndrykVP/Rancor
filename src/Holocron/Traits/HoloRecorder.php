<?php

namespace AndrykVP\Rancor\Holocron\Traits;

use AndrykVP\Rancor\Holocron\Models\Node;

trait HoloRecorder
{
    /**
     * Relationship to Node model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function createdNodes()
    {
        return $this->hasMany(Node::class,'id','author_id');
    }

    /**
     * Relationship to Node model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function editedNodes()
    {
        return $this->hasMany(Node::class,'id','editor_id');
    }
}
