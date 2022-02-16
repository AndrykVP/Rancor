<?php

namespace Rancor\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Login;
use Rancor\Audit\Events\EntryUpdate;
use Rancor\Audit\Events\NodeUpdate;
use Rancor\Audit\Events\UserAwards;
use Rancor\Audit\Events\UserUpdate;
use Rancor\Audit\Listeners\CreateNodeLog;
use Rancor\Audit\Listeners\UpdateUserAwards;
use Rancor\Audit\Listeners\UserLoginIP;
use Rancor\Audit\Listeners\UserRank;
use Rancor\Audit\Listeners\UserRegisteredIP;
use Rancor\Audit\Listeners\CreateScanLog;
use Rancor\Forums\Events\CreateReply;
use Rancor\Forums\Events\VisitDiscussion;
use Rancor\Forums\Models\Board;
use Rancor\Forums\Models\Category;
use Rancor\Forums\Observers\BoardObserver;
use Rancor\Forums\Observers\CategoryObserver;
use Rancor\Forums\Listeners\DefaultGroupUser;
use Rancor\Forums\Listeners\IncrementDiscussionViews;
use Rancor\Forums\Listeners\LinkUserDiscussion;
use Rancor\Forums\Listeners\MarkDiscussionRead;

class EventServiceProvider extends ServiceProvider
{

	protected $listen = [
		Registered::class => [
			UserRegisteredIP::class,
			DefaultGroupUser::class,
		],
		Login::class => [
			UserLoginIP::class,
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
			CreateNodeLog::class,
		],
		UserAwards::class => [
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

		// Register Observers
		Board::observe(BoardObserver::class);
		Category::observe(CategoryObserver::class);
	}
}