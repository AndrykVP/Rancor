<?php

namespace Rancor\DB\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupsSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		/**
		 * Adds the Default usergroup for forum usage
		 */
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