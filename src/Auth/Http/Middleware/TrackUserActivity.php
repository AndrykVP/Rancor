<?php

namespace AndrykVP\Rancor\Auth\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Closure;
use App\Models\User;

class TrackUserActivity
{
   /**
    * Handle an incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Closure  $next
    * @return mixed
    */
   public function handle(Request $request, Closure $next)
   {
      $user = $request->user();

      if($user != null) $this->store_cache($user);

      return $next($request);
   }

   /**
    * Handles the logic of the Cache
    *
    * @param App\Models\User  $user
    * @return void
    */
   public function store_cache(User $user)
   {
      if(Cache::has('user-is-online-' . $user->id))
      {
         $previous_activity = Cache::get('user-is-online-' . $user->id);
         $increment = $previous_activity->diffInMinutes(now());

         if($increment > 0)
         {
            Cache::put('user-is-online-' . $user->id, now(), now()->addMinutes(15));
            $this->update_activity($user->id, $increment);
         }
      }
      else
      {
         Cache::add('user-is-online-' . $user->id, now(), now()->addMinutes(15));
         $this->update_activity($user->id, 0);
      }

   }

   /**
    * Updates the online_time column of the User
    *
    * @param int  $user_id
    * @param int  $increment
    * @return void
    */
   public function update_activity(Int $user_id, Int $increment=0)
   {
      DB::table('users')
         ->where('id', $user_id)
         ->when($increment > 0, function($query) use ($increment) {
            $query->increment('online_time', $increment);
         })
         ->update(['last_seen_at' => now()]);
   }
}