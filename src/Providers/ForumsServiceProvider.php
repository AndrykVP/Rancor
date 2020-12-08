<?php

namespace AndrykVP\Rancor\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use AndrykVP\Rancor\Forum\Board;
use AndrykVP\Rancor\Forum\Category;
use AndrykVP\Rancor\Forum\Discussion;
use AndrykVP\Rancor\Forum\Group;
use AndrykVP\Rancor\Forum\Reply;
use AndrykVP\Rancor\Forum\Policies\BoardPolicy;
use AndrykVP\Rancor\Forum\Policies\CategoryPolicy;
use AndrykVP\Rancor\Forum\Policies\DiscussionPolicy;
use AndrykVP\Rancor\Forum\Policies\GroupPolicy;
use AndrykVP\Rancor\Forum\Policies\ReplyPolicy;

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
        
        // Register policies
        $this->registerPolicies();

        // Publish Assets
        $this->publishes([
            __DIR__.'/../Forums/Http/Controllers' => app_path('Http/Controllers/Rancor/Forums'),
            __DIR__.'/../Forums/Http/Requests' => app_path('Http/Requests/Rancor/Forums'),
            __DIR__.'/../Forums/Http/Resources' => app_path('Http/Resources/Rancor/Forums'),
        ], 'http');        
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