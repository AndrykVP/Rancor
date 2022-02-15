<?php

namespace Rancor\Audit\Listeners;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Rancor\Audit\Events\UserAwards;
use Illuminate\Support\Collection;

class UpdateUserAwards
{
	/**
	 * User making edits to another user's awards
	 * 
	 * @var App\Models\User
	 */
	protected $admin;

	/**
	 * Create the event listener.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return void
	 */
	public function __construct(Request $request)
	{
		$this->admin = $request->user();
	}

	/**
	 * Handle the event.
	 *
	 * @param  \Rancor\Audit\Events\UserAwards  $event
	 * @return void
	 */
	public function handle(UserAwards $event)
	{
		$data = $this->makeLogTable($event->user, $event->awards);
		if($data->isNotEmpty())
		{
			DB::table('changelog_awards')->insert($data->toArray());
		}
	}

	/**
	 * Create Array to Insert to Database
	 * 
	 * @param \App\Modes\User $event
	 * @return \Illuminate\Support\Collection
	 */
	private function makeLogTable(User $user, Collection $awards)
	{
		$data = collect([]);
		foreach($awards as $award_id => $level)
		{
			$existing_award = $user->awards->firstWhere('id', $award_id);
			$change = $this->getAction($existing_award, $level['level']);
			
			if($change != 0)
			{
				$data->push([
					'award_id' => $award_id,
					'user_id' => $user->id,
					'action' => $change,
					'updated_by' => $this->admin->id,
					'created_at' => now(),
					'updated_at' => now(),
				]);
			}
		}

		foreach($user->awards as $award)
		{
			if(!$awards->contains('id', '=', $user->awards->id))
			{
				$data->push([
					'award_id' => $award->id,
					'user_id' => $user->id,
					'action' => (- $award->pivot->level),
					'updated_by' => $this->admin->id,
					'created_at' => now(),
					'updated_at' => now(),
				]);
			}
		}
		return $data;
	}

	/**
	 * Return Integer difference between new Award and Old Award
	 * 
	 * @param null|object  $award
	 * @param integer  $level
	 */
	private function getAction(?Object $award, Int $level)
	{
		if(!isset($award)) return $level;

		return $level - $award->pivot->level;
	}
}
