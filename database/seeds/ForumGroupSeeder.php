<?php

namespace AndrykVP\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ForumGroupSeeder extends Seeder
{
   /**
    * Run the database seeds.
    *
    * @return void
    */
   public function run()
   {
      DB::table('forum_groups')->insert([
         [
            'name' => 'Guests',
            'description' => 'Default usergroup for new members',
            'created_at' => now(),
            'updated_at' => now(),
         ]
      ]);
   }
}