<?php

namespace AndrykVP\SWC\Providers;

use Illuminate\Support\ServiceProvider;
use AndrykVP\SWC\Commands\SyncDatabase;
use AndrykVP\SWC\Helpers\IDGen;

class SWCServiceProvider extends ServiceProvider
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
        __DIR__.'/../config/APIconfig.php' => config_path('swc.php'),
        __DIR__.'/../config/IDGenconfig.php' => config_path('idgen.php'),
      ]);

      // Merge Configuration for access in Package Helpers
      $this->mergeConfigFrom(
        __DIR__.'/../config/IDGenconfig.php', 'idgen'
      );

      // Instantiate IDGen and bind to app for global access
      $this->app->singleton('idgen', function()
      {
        return new IDGen();
      });

      // Shortcut so developers don't need to add an Alias in app/config/app.php
      $this->app->booting(function()
      {
          $loader = \Illuminate\Foundation\AliasLoader::getInstance();
          $loader->alias('IDGen', 'AndrykVP\SWC\Facades\IDGen');
      });

      // Shortcut so developers don't need to add to array in app/config/filesystems.php
      $this->app->config['filesystems.disks.idgen'] = [
        'driver' => 'local',
        'root' => storage_path('app/idgen'),
        'url' => env('APP_URL').'/idgen',
        'visibility' => 'private',
      ];

      $this->app->config['filesystems.links'.public_path('idgen')] = storage_path('app/idgen');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
      // Load routes and migrations
      $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');
      $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

      // Bind Package's console commands
      if ($this->app->runningInConsole()) {
        $this->commands([
            SyncDatabase::class,
        ]);
      }
    }
}
