<?php

namespace Rancor\Auth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAccess
{
<<<<<<< HEAD
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if ($request->user()->hasPermission('view-admin-panel'))
		{
			return $next($request);
		}
=======
    public function handle(Request $request, Closure $next): Request|Closure
    {
        if ($request->user()->hasPermission('view-admin-panel'))
        {
            return $next($request);
        }
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6

		return abort(403, "You do not have access to admin areas");
	}
}
