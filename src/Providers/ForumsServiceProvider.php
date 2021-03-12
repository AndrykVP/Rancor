<?php

namespace AndrykVP\Rancor\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;
use AndrykVP\Rancor\Forums\Models\Board;
use AndrykVP\Rancor\Forums\Models\Category;
use AndrykVP\Rancor\Forums\Models\Discussion;
use AndrykVP\Rancor\Forums\Models\Group;
use AndrykVP\Rancor\Forums\Models\Reply;
use AndrykVP\Rancor\Forums\Policies\BoardPolicy;
use AndrykVP\Rancor\Forums\Policies\CategoryPolicy;
use AndrykVP\Rancor\Forums\Policies\DiscussionPolicy;
use AndrykVP\Rancor\Forums\Policies\GroupPolicy;
use AndrykVP\Rancor\Forums\Policies\ReplyPolicy;

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
       Reply::class => BoardPolicy::class,
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
        Blade::componentNamespace('Rancor\\Forums\\View\\Components', 'rancor');
        
        // Register policies
        $this->registerPolicies();

        // Publish Assets   
        $this->publishes([
            __DIR__.'/../Forums/Resources/Views' => resource_path('views/rancor'),
        ], 'views');        
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