<?php

namespace AndrykVP\SWC\Providers;

use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
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
      $this->loadRoutesFrom(__DIR__.'/../Auth/Routes/web.php');
    }
}
