<?php

namespace AndrykVP\Rancor\Auth\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use AndrykVP\Rancor\DB\Factories\PermissionFactory;
use App\Models\User;

class Permission extends Model
{
    use HasFactory;
    
    protected $table = 'rancor_permissions';

    protected $fillable = [
        'name',
        'description'
    ];

    public function users(): MorphToMany
    {
        return $this->morphedByMany(User::class,'permissible', 'rancor_permissibles');
    }

    public function roles(): MorphToMany
    {
        return $this->morphedByMany(Role::class,'permissible', 'rancor_permissibles');
    }

    protected static function newFactory(): Factory
    {
        return PermissionFactory::new();
    }
}
