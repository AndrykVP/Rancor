<?php

namespace AndrykVP\Rancor\Audit;

use Illuminate\Database\Eloquent\Model;

class NodeLog extends Model
{
    /**
     * Defines the table name
     * 
     * @var string
     */
    protected $table = 'changelog_nodes';

    /**
     * Relationship to User model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo('App\User', 'updated_by');
    }

    /**
     * Relationship to Award model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function node()
    {
        return $this->belongsTo('AndrykVP\Rancor\Holocron\Node');
    }
}
