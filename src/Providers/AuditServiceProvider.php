<?php

namespace Rancor\Providers;

use Illuminate\Support\ServiceProvider;

class AuditServiceProvider extends ServiceProvider
{
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
		$this->loadRoutesFrom(__DIR__.'/../Audit/Routes/api.php');
		$this->loadRoutesFrom(__DIR__.'/../Audit/Routes/web.php');
	}
}
