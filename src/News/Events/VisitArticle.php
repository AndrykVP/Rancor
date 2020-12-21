<?php

namespace AndrykVP\Rancor\News\Events;

use Illuminate\Http\Request;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use AndrykVP\Rancor\News\Article;

class VisitArticle
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Class Variable Article
     * 
     * @var AndrykVP\Rancor\News\Article
     */
    public $article;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Article $article)
    {
        $this->article = $article;
    }
}
