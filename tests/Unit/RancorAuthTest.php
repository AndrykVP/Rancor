<?php

namespace AndrykVP\Rancor\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Tests\TestCase;
use AndrykVP\Rancor\DB\Seeders\RancorSeeder;

class RancorAuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function permissions_and_roles_can_be_created()
    {
        $this->seed(RancorSeeder::class);
        $this->assertDatabaseCount('rancor_permissions', 78);
        $this->assertDatabaseCount('rancor_roles', 10);
    }
}