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
         Auth::guard('web')->logout();
 
         $request->session()->invalidate();
 
         $request->session()->regenerateToken();

         return redirect('/')->with('banned', true);
      }

      return $next($request);
   }
}
