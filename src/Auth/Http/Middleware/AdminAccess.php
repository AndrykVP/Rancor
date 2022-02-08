<?php

namespace AndrykVP\Rancor\Auth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAccess
{
    public function handle(Request $request, Closure $next): Request|Closure
    {
        if ($request->user()->hasPermission('view-admin-panel'))
        {
            return $next($request);
        }

        return abort(403, "You do not have access to admin areas");
    }
}
