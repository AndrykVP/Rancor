<?php

namespace Rancor\Audit\Listeners;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Rancor\Audit\Events\UserAwards;
use Illuminate\Support\Collection;

class UpdateUserAwards
{
<<<<<<< HEAD
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
=======
   protected $admin;

   public function __construct(Request $request)
   {
      $this->admin = $request->user();
   }

   public function handle(UserAwards $event): void
   {
      $data = $this->makeLogTable($event->user, $event->awards);
      if($data->isNotEmpty())
      {
         DB::table('changelog_awards')->insert($data->toArray());
      }
   }

   private function makeLogTable(User $user, Array $awards): Collection
   {
      $data = collect([]);
      foreach($awards as $awardId => $level)
      {
         $existing_award = $user->awards->firstWhere('id', $awardId);
         $change = $this->getAction($existing_award, $level['level']);
         
         if($change != 0)
         {
            $data->push([
               'award_id' => $awardId,
               'user_id' => $user->id,
               'action' => $change,
               'updated_by' => $this->admin->id,
               'created_at' => now(),
               'updated_at' => now(),
            ]);
         }
      }
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6

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

<<<<<<< HEAD
	/**
	 * Return Integer difference between new Award and Old Award
	 * 
	 * @param null|object  $award
	 * @param integer  $level
	 */
	private function getAction(?Object $award, Int $level)
	{
		if(!isset($award)) return $level;
=======
   /**
    * Return difference between new Award and Old Award
    */
   private function getAction(?Object $award, Int $level): Int
   {
      if(!isset($award)) return $level;
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6

		return $level - $award->pivot->level;
	}
}
