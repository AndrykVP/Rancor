<?php

namespace Rancor\Providers;

use Illuminate\Support\ServiceProvider;
use Rancor\SWC\Console\Commands\SyncDatabase;

class SWCServiceProvider extends ServiceProvider
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
		// Bind API Console Commands
		if ($this->app->runningInConsole()) {
			$this->commands([
				SyncDatabase::class
			]);
		}
	}
}
