<?php

namespace AndrykVP\Rancor\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Login;
use AndrykVP\Rancor\Auth\Listeners\UserLastLogin;
use AndrykVP\Rancor\Audit\Events\RankChange;
use AndrykVP\Rancor\Audit\Listeners\UserLoginIP;
use AndrykVP\Rancor\Audit\Listeners\UserRegisteredIP;
use AndrykVP\Rancor\Audit\Listeners\UserRank;
use AndrykVP\Rancor\Forums\Listeners\DefaultGroupUser;
use AndrykVP\Rancor\Forums\Events\VisitDiscussion;
use AndrykVP\Rancor\Forums\Events\CreateReply;
use AndrykVP\Rancor\Forums\Listeners\IncrementDiscussionViews;
use AndrykVP\Rancor\Forums\Listeners\MarkDiscussionRead;
use AndrykVP\Rancor\Forums\Listeners\LinkUserDiscussion;
use AndrykVP\Rancor\News\Events\VisitArticle;
use AndrykVP\Rancor\News\Listeners\IncrementArticleViews;

class EventServiceProvider extends ServiceProvider
{

    protected $listen = [
        Registered::class => [
            UserRegisteredIP::class,
            DefaultGroupUser::class,
        ],
        Login::class => [
            UserLoginIP::class,
            UserLastLogin::class,
        ],
        RankChange::class => [
            UserRank::class,
        ],
        VisitDiscussion::class => [
            IncrementDiscussionViews::class,
            MarkDiscussionRead::class,
        ],
        VisitArticle::class => [
            IncrementArticleViews::class,
        ],
        CreateReply::class => [
            LinkUserDiscussion::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}