<?php

namespace Rancor\Auth\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Closure;
use Illuminate\Http\Request;

class UserIsNotBanned
{
<<<<<<< HEAD
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle(Request $request, Closure $next)
	{
		if ($request->user()->is_banned)
		{
			Auth::logout();
=======
   public function handle(Request $request, Closure $next): Request|Closure
   {
      if ($request->user()->is_banned)
      {
         Auth::logout();
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6

			$request->session()->invalidate();
			$request->session()->regenerateToken();

			abort(403, 'Your account has been banned.');
		}

		return $next($request);
	}
}
