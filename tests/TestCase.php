<?php

namespace AndrykVP\Rancor\Tests;

use AndrykVP\Rancor\Providers\PackageServiceProvider;
use Mews\Purifier\PurifierServiceProvider;
use Illuminate\Routing\Router;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            PackageServiceProvider::class,
            PurifierServiceProvider::class
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        //
    }
    
    /**
     * Define database migrations.
     *
     * @return void
     */
    protected function defineDatabaseMigrations()
    {
        $this->loadLaravelMigrations();
    }

    /**
    * Define routes setup.
    *
    * @param  \Illuminate\Routing\Router  $router
    *
    * @return void
    */
    protected function defineRoutes($router)
    {
        $router->get('/login')->name('login');
        $router->post('/logout')->name('logout');
        $router->get('/register')->name('register');
    }
}