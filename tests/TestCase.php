<?php

namespace Rancor\Tests;

use Rancor\Providers\PackageServiceProvider;
use Mews\Purifier\PurifierServiceProvider;

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
        $app['config']->set('auth.guards.api', [
            'driver' => 'token',
            'provider' => 'users',
            'hash' => false,
        ]);
    }

    protected function defineDatabaseMigrations()
    {
        $this->loadLaravelMigrations();
        $this->loadMigrationsFrom(__DIR__ . '/../app/database');
    }
    
    protected function defineRoutes($router)
    {
        $router->get('/login')->name('login');
        $router->post('/logout')->name('logout');
        $router->get('/register')->name('register');
    }
}