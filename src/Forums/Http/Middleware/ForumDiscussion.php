<?php

namespace AndrykVP\Rancor\Forums\Http\Middleware;

use Closure;
use AndrykVP\Rancor\Forums\Discussion;

class ForumDiscussion
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
        $discussion = Discussion::with('board')->findOrFail($request->segment(3));
        $categoryIDs = $request->user()->getCategoryIDs();

        if(!in_array($discussion->board->category_id,$categoryIDs)) abort(401);

        return $next($request);
    }
}
