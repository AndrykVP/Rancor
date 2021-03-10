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
use App\User;

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
      $factions = Faction::factory()->count(4)->create();
      $departments = Department::factory()->count(16)->for($factions->random())->create();
      $ranks = Rank::factory()->count(35)->for($departments->random())->create();
      $types = Type::factory()->count(4)->create();
      $awards = Award::factory()->count(24)->for($types->random())->create();

      /**
       * User Seeding
       */
      $users = User::factory()->count(20)->for($ranks->random())->create();

      /**
       * News Seeding
       */
      $tags = Tag::factory()->count(12)->create();
      $articles = Article::factory()
                  ->count(35)
                  ->has($tags->random(3))
                  ->for($users->random(), 'author')
                  ->create();

      /**
       * Holocron Seeding
       */
      $collections = Collection::factory()->count(12)->create();
      $nodes = Node::factory()
               ->count(35)
               ->has($collections->random(3))
               ->for($users->random(), 'author')
               ->create();

      /**
       * Forum Seeding
       */
      $groups = Group::factory()->count(15)->has($users->random(8))->create();
      $categories = Category::factory()->count(6)->has($groups->random(3))->create();
      $boards = Board::factory()->count(40)->has($groups->random(2))->has($users->random(), 'moderator')->for($category->random())->create();
      $discussions = Discussion::factory()->count(250)->for($boards->random())->for($users->random(), 'author')->create();
      $replies = Reply::factory()->count(5000)->for($discussions->random())->for($users->random(), 'author')->create();

      /**
       * Scanner Seeding
       */
      $entries = Entry::factory()->count(2000)->for($users->random(), 'contributor')->create();
      
   }
}