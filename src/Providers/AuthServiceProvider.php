<?php

namespace AndrykVP\Rancor\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Routing\Router;
use App\Models\User;
use AndrykVP\Rancor\Auth\Models\Permission;
use AndrykVP\Rancor\Auth\Models\Role;
use AndrykVP\Rancor\Auth\Policies\PermissionPolicy;
use AndrykVP\Rancor\Auth\Policies\RolePolicy;
use AndrykVP\Rancor\Auth\Policies\UserPolicy;
use AndrykVP\Rancor\Auth\Http\Middleware\AdminAccess;
use AndrykVP\Rancor\Auth\Http\Middleware\UserIsNotBanned;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Custom Package policies
     * 
     * @var array
     */
    protected $policies = [
        Role::class => RolePolicy::class,
        Permission::class => PermissionPolicy::class,
        User::class => UserPolicy::class,
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
        $this->loadRoutesFrom(__DIR__.'/../Auth/Routes/web.php');

        // Load views
        $this->loadViewsFrom(__DIR__.'/../Auth/Resources/Views','rancor');

        // Register policies
        $this->registerPolicies();

        // Register Middleware Alias
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('admin', AdminAccess::class);
        $router->aliasMiddleware('unbanned', UserIsNotBanned::class);

        // Publish Views
        $this->publishes([
            __DIR__.'/../Auth/Resources/Views' => resource_path('views/vendor/rancor')
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
