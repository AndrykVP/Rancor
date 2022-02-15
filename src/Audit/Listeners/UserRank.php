<?php

namespace AndrykVP\Rancor\Audit\Listeners;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use AndrykVP\Rancor\Audit\Events\UserUpdate;
use AndrykVP\Rancor\Structure\Models\Rank;

class UserRank
{
	/**
	 * ID of user modifying another user's rank
	 * 
	 * @var int
	 */
	public $editor;


	/**
	 * Color variable used in front-end of user log
	 * 
	 * @var string
	 */
	protected $warning, $info, $alert;

	/**
	 * Create the event listener.
	 *
	 * @param  Request  $request
	 * @return void
	 */
	public function __construct(Request $request)
	{
		$this->editor = $request->user()->id;
		$this->warning = config('rancor.audit.warning');
		$this->info = config('rancor.audit.info');
		$this->alert = config('rancor.audit.');
	}

	/**
	 * Handle the event.
	 *
	 * @param  UserUpdate  $event
	 * @return void
	 */
	public function handle(UserUpdate $event)
	{
		// Close the event if the rank was not changed
		if($event->user->isClean('rank_id')) return;
		
		// Create a single event if the rank was removed
		if($event->user->rank_id == null)
		{
			$this->createEntry($event->user->id, 'removed from service', $this->alert);
			return;
		}
		 
		$rank_id = $event->user->getOriginal('rank_id');
		$new_rank = Rank::with('department.faction')->find($event->user->rank_id);

		// Create assignment events when user has a current rank but the previous rank was null
		if($rank_id == null)
		{
			$this->createEntry($event->user->id, "was granted the rank {$new_rank->name} ({$new_rank->level})", $this->info);
			$this->createEntry($event->user->id, "was assigned to the {$new_rank->department->name} department", $this->info);
			$this->createEntry($event->user->id, "was assigned to the {$new_rank->department->faction->name} faction", $this->info);
			return;
		}

		// Continue with the event for cases where rank has been changed to another not null id
		$old_rank = Rank::with('department.faction')->find($rank_id);

		if($old_rank->level != $new_rank->level)
		{
			if($old_rank->level > $new_rank->level) $message = 'was demoted';
			else $message = 'was promoted';

			$message .= " from {$old_rank->name} ({$old_rank->level}) to {$new_rank->name} ({$new_rank->level})";

			$this->createEntry($event->user->id, $message, $this->info);
		} else
		{
			$message = "was granted the rank {$new_rank->name} ({$new_rank->level}) instead of {$old_rank->name} ({$old_rank->level})";

			$this->createEntry($event->user->id, $message, $this->info);
		}

		if($old_rank->department->id != $new_rank->department->id)
		{
			$message = "was reassigned to the {$new_rank->department->name} department";

			$this->createEntry($event->user->id, $message, $this->info);
		}

		if($old_rank->department->faction->id != $new_rank->department->faction->id)
		{
			$message = "was reassigned to the {$new_rank->department->faction->name} faction";

			$this->createEntry($event->user->id, $message, $this->info);
		}
	}

	/**
	 * Create database entry.
	 *
	 * @param int  $id
	 * @param string  $action
	 * @param string  $color
	 * @return void
	 */
	private function createEntry(Int $id, String $action, String $color)
	{
		DB::table('changelog_users')->insert([
			'user_id' => $id,
			'updated_by' => $this->editor,
			'action' => $action,
			'color' => $color,
			'created_at' => now(),
			'updated_at' => now(),
		]);
	}
}
