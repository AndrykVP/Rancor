<?php

namespace Rancor\Auth\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
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
	public function handle(Request $request, Closure $next)
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
