<?php

namespace AndrykVP\Rancor\Audit\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use AndrykVP\Rancor\Audit\Enums\Access;
use AndrykVP\Rancor\Audit\Models\IPLog as Log;

class UserLoginIP
{
   protected $ip_address;
   protected $user_agent;
   
   public function __construct(Request $request)
   {
      $this->ip_address = $request->ip();
      $this->user_agent = $request->header('User-Agent');
   }

   public function handle(Login $event): void
   {
      Log::updateOrCreate(
         ['user_id' => $event->user->id, 'ip_address' => $this->ip_address, 'type' => Access::LOGIN],
         ['user_agent' => $this->user_agent]
      );
   }
}
