<?php

namespace AndrykVP\Rancor\Forums\Http\Middleware;

use Closure;
use AndrykVP\Rancor\Forums\Category;

class ForumCategory
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
        $discussion = Category::with('board')->where('slug',$request->segment(2));
        if($board == null) abort(404);

        $categoryIDs = $request->user()->getCategoryIDs();
        if(!in_array($discussion->board->category_id,$categoryIDs)) abort(401);

        return $next($request);
    }
}
