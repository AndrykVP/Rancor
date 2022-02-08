<?php

namespace AndrykVP\Rancor\Audit\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use AndrykVP\Rancor\Audit\Contracts\LogContract;
use AndrykVP\Rancor\DB\Factories\UserLogFactory;
use App\Models\User;

class UserLog extends Model implements LogContract
{
   use HasFactory;

   protected $table = 'changelog_users';

   protected $fillable = [
      'user_id',
      'updated_by',
      'action',
      'color'
   ];

   public function user(): BelongsTo
   {
      return $this->belongsTo(User::class);
   }

   public function creator(): BelongsTo
   {
      return $this->belongsTo(User::class,'updated_by');
   }

   public function message(): string
   {
      $message = $this->user->name . ' ' . $this->action;
      if($this->upated_by != null)
      {
         $message = $message . ' by ' . $this->creator->name;
      }
      return $message;
   }

   protected static function newFactory(): Factory
   {
      return UserLogFactory::new();
   }
}
