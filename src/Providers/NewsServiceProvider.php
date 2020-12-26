<?php

namespace AndrykVP\Rancor\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use AndrykVP\Rancor\News\Article;
use AndrykVP\Rancor\News\Policies\ArticlePolicy;
use AndrykVP\Rancor\News\Tag;
use AndrykVP\Rancor\News\Policies\TagPolicy;

class NewsServiceProvider extends ServiceProvider
{
    /**
     * Custom Package policies
     * 
     * @var array
     */
    protected $policies = [
        Article::class => ArticlePolicy::class,
        Tag::class => TagPolicy::class,
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
        $this->loadRoutesFrom(__DIR__.'/../News/Routes/api.php');
        $this->loadRoutesFrom(__DIR__.'/../News/Routes/web.php');

        // Load views
        $this->loadViewsFrom(__DIR__.'/../News/Resources/Views','rancor');
        
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