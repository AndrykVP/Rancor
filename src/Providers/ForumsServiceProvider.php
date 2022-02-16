<?php

namespace Rancor\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Rancor\Forums\Models\Board;
use Rancor\Forums\Models\Category;
use Rancor\Forums\Models\Discussion;
use Rancor\Forums\Models\Group;
use Rancor\Forums\Models\Reply;
use Rancor\Forums\Policies\BoardPolicy;
use Rancor\Forums\Policies\CategoryPolicy;
use Rancor\Forums\Policies\DiscussionPolicy;
use Rancor\Forums\Policies\GroupPolicy;
use Rancor\Forums\Policies\ReplyPolicy;

class ForumsServiceProvider extends ServiceProvider
{
	/**
	 * Custom Package policies
	 * 
	 * @var array
	 */
	protected $policies = [
	   Board::class => BoardPolicy::class,
	   Category::class => CategoryPolicy::class,
	   Discussion::class => DiscussionPolicy::class,
	   Group::class => GroupPolicy::class,
	   Reply::class => ReplyPolicy::class,
	];

	/**
	 * Register services.
	 *
	 * @return void
	 */
	public function register()
	{
	  //
	}

	/**
	 * Bootstrap services.
	 *
	 * @return void
	 */
	public function boot()
	{
		// Load routes
		$this->loadRoutesFrom(__DIR__.'/../Forums/Routes/api.php');
		$this->loadRoutesFrom(__DIR__.'/../Forums/Routes/web.php');

		// Load views
		$this->loadViewsFrom(__DIR__.'/../Forums/Resources/Views', 'rancor');
		
		// Register policies
		$this->registerPolicies();

		// Publish Assets   
		$this->publishes([
			__DIR__.'/../Forums/Resources/Views' => resource_path('views/vendor/rancor'),
		], 'rancor-views');        
	}

	/**
	 * Method to register custom policies
	 * 
	 * @return void
	 */
	public function registerPolicies()
	{
		foreach ($this->policies as $key => $value) {
			Gate::policy($key, $value);
		}
	}
}