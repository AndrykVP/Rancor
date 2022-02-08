<?php

namespace AndrykVP\Rancor\Audit\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use AndrykVP\Rancor\Audit\Enums\Access;
use AndrykVP\Rancor\DB\Factories\IPLogFactory;
use App\Models\User;

class IPLog extends Model
{
   use HasFactory;

   protected $table = 'changelog_ips';

   protected $fillable = [
      'user_id',
      'ip_address',
      'type',
      'user_agent',
   ];

   protected $casts = [
      'type' => Access::class,
   ];

   public function user(): BelongsTo
   {
      return $this->belongsTo(User::class);
   }

   public function creator(): BelongsTo
   {
      return $this->belongsTo(User::class,'updated_by');
   }

   protected static function newFactory(): Factory
   {
      return IPLogFactory::new();
   }
}
