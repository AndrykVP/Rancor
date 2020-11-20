<?php

namespace AndrykVP\Rancor\Forums\Http\Middleware;

use Closure;
use AndrykVP\Rancor\Forums\Board;

class ForumBoard
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
        $board = Board::where('slug',$request->segment(3))->first();
        if($board == null) abort(404);

        $categoryIDs = $request->user()->getCategoryIDs();
        if(!in_array($board->category_id,$categoryIDs)) abort(401);

        return $next($request);
    }
}
