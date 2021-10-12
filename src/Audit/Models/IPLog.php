<?php

namespace AndrykVP\Rancor\Audit\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use AndrykVP\Rancor\Audit\Contracts\LogContract;

class IPLog extends Model implements LogContract
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
