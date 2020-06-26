<?php

namespace AndrykVP\SWC\Providers;

use Illuminate\Support\ServiceProvider;
use AndrykVP\SWC\API\Commands\SyncDatabase;

class APIServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
      // Publish Configuration
      $this->publishes([
        __DIR__.'/API/config.php' => config_path('swcapi.php'),
      ]);
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
            SyncDatabase::class,
        ]);
      }
    }
}
