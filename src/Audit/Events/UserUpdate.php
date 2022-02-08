<?php

namespace AndrykVP\Rancor\Audit\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class UserUpdate
{
   use Dispatchable, InteractsWithSockets, SerializesModels;

   public $user;
   public $generateId;

   public function __construct(User $user, Bool $generateId)
   {
      $this->user = $user;
      $this->generateId = $generateId;
   }
}
