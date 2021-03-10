<?php

namespace AndrykVP\Rancor\Database\Seeders;

use Illuminate\Database\Seeder;
use AndrykVP\Rancor\Structure\Models\Award;
use AndrykVP\Rancor\Structure\Models\Department;
use AndrykVP\Rancor\Structure\Models\Faction;
use AndrykVP\Rancor\Structure\Models\Rank;
use AndrykVP\Rancor\Structure\Models\Type;
use AndrykVP\Rancor\News\Models\Article;
use AndrykVP\Rancor\News\Models\Tag;
use AndrykVP\Rancor\Holocron\Models\Collection;
use AndrykVP\Rancor\Holocron\Models\Node;
use AndrykVP\Rancor\Forums\Models\Board;
use AndrykVP\Rancor\Forums\Models\Category;
use AndrykVP\Rancor\Forums\Models\Discussion;
use AndrykVP\Rancor\Forums\Models\Group;
use AndrykVP\Rancor\Forums\Models\Reply;
use AndrykVP\Rancor\Scanner\Models\Entry;
use App\Models\User;

class TestSeeder extends Seeder
{
   /**
    * Run the database seeds.
    *
    * @return void
    */
   public function run()
   {
      /** 
       * Structure Seeding
       */
      $factions = Faction::factory()->count(4)->has(
         Department::factory()
                     ->count(3)
                     ->has(Rank::factory()->count(12))
                     )->create();

      $types = Type::factory()
                     ->count(4)
                     ->has(Award::factory()->count(8))
                     ->create();

      /**
       * User Seeding
       */
      $users = User::factory()->count(20)->for($ranks->random())->create();

      /**
       * News Seeding
       */
      $tags = Tag::factory()
               ->count(12)
               ->has(Article::factory()
                     ->count(35)
                     ->for($users->random(), 'author')
               )->create();

      /**
       * Holocron Seeding
       */
      $collections = Collection::factory()
                     ->count(12)
                     ->has(Node::factory()
                           ->count(15)
                           ->for($users->random(), 'author')
                     )->create();

      /**
       * Forum Seeding
       */
      $groups = Group::factory()
                     ->count(15)
                     ->has(Category::factory()
                           ->count(6)
                           ->has(Board::factory()
                                 ->count(40)
                                 ->has($users->random(), 'moderator')
                                 ->has(Discussion::factory()
                                       ->count(250)
                                       ->for($users->random(), 'author')
                                       ->has(Reply::factory()
                                             ->count(5000)
                                             ->for($users->random(), 'author')
                                       )
                                 )
                           )
                     )
                     ->create();

      /**
       * Scanner Seeding
       */
      $entries = Entry::factory()->count(2000)->for($users->random(), 'contributor')->create();
      
   }
}