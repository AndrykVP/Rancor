<?php

namespace AndrykVP\Rancor\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Login;
use AndrykVP\Rancor\Audit\Events\EntryUpdate;
use AndrykVP\Rancor\Audit\Events\NodeUpdate;
use AndrykVP\Rancor\Audit\Events\UserAward;
use AndrykVP\Rancor\Audit\Events\UserUpdate;
use AndrykVP\Rancor\Forums\Events\CreateReply;
use AndrykVP\Rancor\Forums\Events\VisitDiscussion;
use AndrykVP\Rancor\Audit\Listeners\SetNodeEditor;
use AndrykVP\Rancor\Audit\Listeners\UpdateUserAwards;
use AndrykVP\Rancor\Audit\Listeners\UserLoginIP;
use AndrykVP\Rancor\Audit\Listeners\UserRank;
use AndrykVP\Rancor\Audit\Listeners\UserRegisteredIP;
use AndrykVP\Rancor\Auth\Listeners\UserLastLogin;
use AndrykVP\Rancor\Audit\Listeners\CreateScanLog;
use AndrykVP\Rancor\Forums\Listeners\DefaultGroupUser;
use AndrykVP\Rancor\Forums\Listeners\IncrementDiscussionViews;
use AndrykVP\Rancor\Forums\Listeners\LinkUserDiscussion;
use AndrykVP\Rancor\Forums\Listeners\MarkDiscussionRead;

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
        UserUpdate::class => [
            UserRank::class,
        ],
        VisitDiscussion::class => [
            IncrementDiscussionViews::class,
            MarkDiscussionRead::class,
        ],
        CreateReply::class => [
            LinkUserDiscussion::class,
        ],
        EntryUpdate::class => [
            CreateScanLog::class,
        ],
        NodeUpdate::class => [
            SetNodeEditor::class,
        ],
        UserAward::class => [
            UpdateUserAwards::class,
        ]
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