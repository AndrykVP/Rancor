<?php

namespace AndrykVP\Rancor\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Relations\Relation;
use AndrykVP\Rancor\Auth\Role;
use AndrykVP\Rancor\Auth\Policies\RolePolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Custom Package policies
     * 
     * @var array
     */
    protected $policies = [
        Role::class => RolePolicy::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Automatically publish database Seeds and UserPolicy
        $this->publishes([
            __DIR__.'/../../database/seeds/PermissionSeeder.php' => database_path('seeds/PermissionSeeder.php'),
            __DIR__.'/../../database/seeds/RoleSeeder.php' => database_path('seeds/RoleSeeder.php'),
        ]);
        $this->publishes([
            __DIR__.'/../Auth/Policies/UserPolicy.php' => app_path('Policies/UserPolicy.php')
        ]);

        // Merge Configuration for access in Package Helpers
        $this->mergeConfigFrom(
            __DIR__.'/../../config/auth.php', 'rancor'
        );
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

        // Publish config file
        $this->publishes([
            __DIR__.'/../../config/auth.php' => config_path('rancor.php'),
        ]);

        // Register policies
        $this->registerPolicies();
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
