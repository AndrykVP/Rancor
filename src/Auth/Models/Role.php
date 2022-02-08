<?php

namespace AndrykVP\Rancor\Auth\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use AndrykVP\Rancor\DB\Factories\RoleFactory;
use App\Models\User;

class Role extends Model
{
    use HasFactory;

    protected $table = 'rancor_roles';

    protected $fillable = [
        'name',
        'description'
    ];

    public function permissions(): MorphToMany
    {
        return $this->morphToMany(Permission::class, 'permissible', 'rancor_permissibles')->withTimestamps();
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'rancor_role_user')->withTimestamps();
    }

    protected static function newFactory(): Factory
    {
        return RoleFactory::new();
    }
}
