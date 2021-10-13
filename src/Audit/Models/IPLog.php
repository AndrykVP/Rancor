<?php

namespace AndrykVP\Rancor\Audit\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class IPLog extends Model
{
    /**
     * Defines the table name
     * 
     * @var string
     */
    protected $table = 'changelog_ips';

    
    /**
     * Attributes available for mass assignment
     * 
     * @var array
     */
    protected $fillable = [ 'user_id', 'ip_address', 'type', 'user_agent' ];

    /**
     * Relationship to User model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship to Role model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function creator()
    {
        return $this->belongsTo(User::class,'updated_by');
    }
}
