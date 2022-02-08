<?php

namespace AndrykVP\Rancor\Auth\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;

class UserIsNotBanned
{
   public function handle(Request $request, Closure $next): Request|Closure
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
