<?php

namespace Rancor\Package\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Cache;
use App\Models\User;

class OnlineUsers extends Component
{
   /**
    * Color to use when displaying alert
    * 
    * @var Illuminate\Database\Eloquent\Collection
    */
   public $users;

   /**
    * Create a new component instance.
    *
    * @return void
    */
   public function __construct()
   {
      $this->users = Cache::remember('online-users', 60, function () {
         return User::select('id', 'first_name', 'last_name')
               ->where('last_seen_at', '>', now()->subMinutes(15))
               ->get();
      });
   }

   /**
    * Get the view / contents that represent the component.
    *
    * @return \Illuminate\Contracts\View\View|string
    */
   public function render()
   {
      return view('rancor::components.onlineusers');
   }
}
