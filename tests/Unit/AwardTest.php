<?php

namespace AndrykVP\Rancor\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Structure\Models\Award;
use AndrykVP\Rancor\Tests\TestCase;
use App\Models\User;

class AwardTest extends TestCase
{
    use RefreshDatabase;

    protected $award;

    public function setUp(): void
    {
        parent::setUp();

        $award = Award::factory()
        ->forType()
        ->hasAttached(User::factory()->count(4), ['level' => 2])
        ->create([
            'name' => 'Fake Title',
            'description' => 'Ex enim reprehenderit ut ad do adipisicing excepteur ut aute eu deserunt.',
            'code' => 'Fake Code',
            'levels' => 3,
            'priority' => 7
        ]);
        
        $this->assertNotNull($award);
        $this->award = $award->load('users');
    }

    /** 
     * @test
     */
    function award_has_name()
    {
        $this->assertEquals('Fake Title', $this->award->name);
    }

    /** 
     * @test
     */
    function award_has_description()
    {
        $this->assertEquals('Ex enim reprehenderit ut ad do adipisicing excepteur ut aute eu deserunt.', $this->award->description);
    }

    /**
     * @test
     */
    function award_has_code()
    {
        $this->assertEquals('Fake Code', $this->award->code);
    }

    /**
     * @test
     */
    function award_has_levels()
    {
        $this->assertEquals(3, $this->award->levels);
    }

    /**
     * @test
     */
    function award_has_priority()
    {
        $this->assertEquals(7, $this->award->priority);
    }

    /**
     * @test
     */
    function award_has_type()
    {
        $this->assertNotNull($this->award->type_id);
    }

    /**
     * @test
     */
    function award_has_users()
    {
        $this->assertCount(4, $this->award->users);
    }
}