<?php

namespace AndrykVP\Rancor\Audit\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use AndrykVP\Rancor\Audit\Contracts\LogContract;
use AndrykVP\Rancor\DB\Factories\BanLogFactory;
use App\Models\User;

class BanLog extends Model implements LogContract
{
   use HasFactory;
   
   protected $table = 'changelog_bans';

   protected $fillable = [ 'user_id', 'updated_by', 'status', 'reason'];

   protected $casts = [
      'status' => 'boolean',
   ];

   public function user(): BelongsTo
   {
      return $this->belongsTo(User::class);
   }

   public function creator(): BelongsTo
   {
      return $this->belongsTo(User::class, 'updated_by');
   }

   public function message(): string
   {
      return $this->user->name . 'has been ' . ($this->status ? 'banned' : 'unbanned') . ' by ' . $this->creator->name . ' with reason: ' . $this->reason;
   }

   protected static function newFactory(): Factory
   {
      return BanLogFactory::new();
   }
}
