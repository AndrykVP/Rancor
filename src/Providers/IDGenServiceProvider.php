<?php

namespace AndrykVP\SWC\Providers;

use Illuminate\Support\ServiceProvider;
use AndrykVP\SWC\IDGen\Helpers\IDGenHelper;

class IDGenServiceProvider extends ServiceProvider
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
        __DIR__.'/../IDGen/config.php' => config_path('idgen.php'),
      ]);

      // Merge Configuration for access in Package Helpers
      $this->mergeConfigFrom(
        __DIR__.'/../IDGen/config.php', 'idgen'
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
          $loader->alias('IDGen', 'AndrykVP\SWC\IDGen\Facades\IDGenFacade');
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
      //
    }
}
