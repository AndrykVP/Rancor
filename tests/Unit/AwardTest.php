<?php

namespace AndrykVP\Rancor\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use AndrykVP\Rancor\Structure\Models\Award;
use AndrykVP\Rancor\Tests\TestCase;
use App\Models\User;

class AwardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function make_award()
    {
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
        return $award->load('users');
    }

    /** 
     * @test
     * @depends make_award
     */
    function award_has_name($award)
    {
        $this->assertEquals('Fake Title', $award->name);
    }

    /** 
     * @test
     * @depends make_award
     */
    function award_has_description($award)
    {
        $this->assertEquals('Ex enim reprehenderit ut ad do adipisicing excepteur ut aute eu deserunt.', $award->description);
    }

    /**
     * @test
     * @depends make_award
     */
    function award_has_code($award)
    {
        $this->assertEquals('Fake Code', $award->code);
    }

    /**
     * @test
     * @depends make_award
     */
    function award_has_levels($award)
    {
        $this->assertEquals(3, $award->levels);
    }

    /**
     * @test
     * @depends make_award
     */
    function award_has_priority($award)
    {
        $this->assertEquals(7, $award->priority);
    }

    /**
     * @test
     * @depends make_award
     */
    function award_has_type($award)
    {
        $this->assertNotNull($award->type_id);
    }

    /**
     * @test
     * @depends make_award
     */
    function award_has_users($award)
    {
        $this->assertNotEmpty($award->users);
    }
}