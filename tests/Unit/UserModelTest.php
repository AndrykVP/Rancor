<?php

namespace Rancor\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Rancor\Tests\TestCase;
use App\Models\User;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()
        ->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'example@example.com',
            'nickname' => 'Johnny',
            'quote' => 'Lorem Ipsum',
        ]);
        
        $this->assertNotNull($user);
        $this->user = $user;
    }

    /** 
     * @test
     */
    function user_has_first_name()
    {
        $this->assertEquals('John', $this->user->first_name);
    }

    /** 
     * @test
     */
    function user_has_last_name()
    {
        $this->assertEquals('Doe', $this->user->last_name);
    }
    
    /**
     * @test
     */
    function user_has_nickname()
    {
        $this->assertEquals('Johnny', $this->user->nickname);
    }

    /** 
     * @test
     */
    function user_has_name()
    {
        $this->assertEquals('John Doe', $this->user->name);
    }

    /**
     * @test
     */
    function user_has_email()
    {
        $this->assertEquals('example@example.com', $this->user->email);
    }
    
    /**
     * @test
     */
    function user_has_quote()
    {
        $this->assertEquals('Lorem Ipsum', $this->user->quote);
    }
}