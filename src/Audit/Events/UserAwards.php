<?php

namespace AndrykVP\Rancor\Audit\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use AndrykVP\Rancor\Structure\Models\Award;

class UserAwards
{
   use Dispatchable, InteractsWithSockets, SerializesModels;

   public $user;
   public $awards;

   public function __construct(User $user, Array $awards)
   {
      $this->user = $user->load('awards');
      $this->awards = $awards;
   }
}
