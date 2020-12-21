<?php

namespace AndrykVP\Rancor\News\Listeners;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use AndrykVP\Rancor\News\Events\VisitArticle;

class IncrementArticleViews
{
    public $visited_articles;

    /**
     * Class constructor
     */
    public function __construct(Request $request)
    {
        $this->visited_articles = $request->session()->get('visited_articles', array());
    }

    /**
     * Handle the event.
     *
     * @param  VisitArticle  $event
     * @return void
     */
    public function handle(VisitArticle $event)
    {
        if(!in_array($event->article->id,$this->visited_articles))
        {
            DB::table('forum_articles')
                ->where('id', $event->article->id)
                ->increment('views');
        }
    }
}
