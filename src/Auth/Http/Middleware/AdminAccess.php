<?php

namespace AndrykVP\Rancor\Auth\Http\Middleware;

use Closure;

class AdminAccess
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
        if ($request->user()->hasPermission('view-admin-panel'))
        {
            return $next($request);
        }

        return abort(401);
    }
}
