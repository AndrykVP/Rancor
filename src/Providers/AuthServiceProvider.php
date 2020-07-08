<?php

namespace AndrykVP\Rancor\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

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
        $this->loadRoutesFrom(__DIR__.'/../Auth/Routes/api.php');

        Relation::morphMap([
            'users' => 'App\User',
            'roles' => 'AndrykVP\Rancor\Auth\Role',
        ]);
    }
}
