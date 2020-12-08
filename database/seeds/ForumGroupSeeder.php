<?php

use Illuminate\Database\Seeder;

class ForumGroupSeeder extends Seeder
{
   /**
    * Run the database seeds.
    *
    * @return void
    */
   public function run()
   {
      DB::table('permissions')->insert([
         [
            'name' => 'Guests',
            'description' => 'Default usergroup for new members',
            'color' => '#6c757d'
         ]
      ]);
   }
}