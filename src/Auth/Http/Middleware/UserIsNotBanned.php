<?php

namespace AndrykVP\Rancor\Auth\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

class UserIsNotBanned
{
   /**
    * Handle an incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Closure  $next
    * @return mixed
    */
   public function handle($request, Closure $next)
   {
      // Log user out if banned, and redirect to index
      if ($request->user()->is_banned)
      {
         return redirect(route('profile.index'))->with('alert', [
            'color' => 'red',
            'message' => 'This account has been banned. Contact administration for clarification.'
         ]);
      }

      return $next($request);
   }
}
