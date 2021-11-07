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
      if ($request->user()->is_banned)
      {
         Auth::logout();

         $request->session()->invalidate();
         $request->session()->regenerateToken();

         abort(403, 'Your account has been banned.');
      }

      return $next($request);
   }
}
