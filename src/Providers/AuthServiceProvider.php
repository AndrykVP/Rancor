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

        // Automatically publish database Seeds and UserPolicy
        $this->publishes([
            __DIR__.'/../../database/seeds/PermissionSeeder.php' => database_path('seeds/PermissionSeeder.php'),
            __DIR__.'/../../database/seeds/RoleSeeder.php' => database_path('seeds/RoleSeeder.php'),
        ], 'seeders');

        // Publish Http Files
        $this->publishes([
            __DIR__.'/../Auth/Http/Controllers' => app_path('Http/Controllers/Rancor/Auth'),
            __DIR__.'/../Auth/Http/Requests' => app_path('Http/Requests/Rancor/Auth'),
            __DIR__.'/../Auth/Http/Resources' => app_path('Http/Resources/Rancor/Auth'),
        ], 'http');

        // Publish Policies
        $this->publishes([
            __DIR__.'/../Auth/Policies/UserPolicy.php' => app_path('Policies/UserPolicy.php')
        ], 'policies');

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
