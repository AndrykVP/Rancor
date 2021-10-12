<?php

namespace AndrykVP\Rancor\Audit\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use AndrykVP\Rancor\Audit\Contracts\LogContract;
use AndrykVP\Rancor\Holocron\Models\Node;

class NodeLog extends Model implements LogContract
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
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Relationship to Award model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function node()
    {
        return $this->belongsTo(Node::class);
    }

    /**
     * Method to render Log message in views
     * 
     * @return string
     */
    public function message()
    {
        return '';
    }
}
