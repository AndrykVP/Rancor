<?php

namespace Rancor\Audit\Listeners;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Rancor\Audit\Events\UserUpdate;
use Rancor\Structure\Models\Rank;

class UserRank
{
<<<<<<< HEAD
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
=======
   public $editor;
   protected $warning, $info, $alert;

   public function __construct(Request $request)
   {
      $this->editor = $request->user()->id;
      $this->warning = config('rancor.audit.warning');
      $this->info = config('rancor.audit.info');
      $this->alert = config('rancor.audit.');
   }

   /**
    * Handle the event.
    */
   public function handle(UserUpdate $event): void
   {
      if($event->user->isClean('rank_id')) return;
      if($event->user->rank_id != null)
      {
         $this->parseChanges($event);
         return;
      }
      // If rank was changed to null
      $this->createEntry($event->user->id, 'removed from service', $this->alert);   
   }

   /**
    * Parse Changes
    */
   private function parseChanges(UserUpdate $event): void
   {
      $original_rank = $event->user->getOriginal('rank_id');
      $new_rank = Rank::with('department.faction')->find($event->user->rank_id);

      // Rank assignment
      if($original_rank == null)
      {
         $this->createEntry($event->user->id, 'was assigned the ' . $new_rank->name . ' rank', $this->info);
         $this->createEntry($event->user->id, 'was assigned to the ' . $new_rank->department->name . ' department', $this->info);
         $this->createEntry($event->user->id, 'was assigned to the ' . $new_rank->department->faction->name . ' faction', $this->info);
         return;
      }
      
      // Rank change
      $old_rank = Rank::with('department.faction')->find($original_rank);
      $this->makeAllEntries($event->user->id, $new_rank, $old_rank);
   }

   /**
    * Build message to add to database
    */
   private function makeAllEntries(Int $user_id, Rank $new_rank, Rank $old_rank): void
   {
      // Change of Rank Level
      if($old_rank->level != $new_rank->level)
      {
         $message = $old_rank->level < $new_rank->level ? 'was promoted' : 'was demoted';
         $message .= " from {$old_rank->name} ({$old_rank->level}) to {$new_rank->name} ({$new_rank->level})";
         $this->createEntry($user_id, $message, $this->info);
      }

      // Change of Department
      if($old_rank->department->id != $new_rank->department->id)
      {
         $message = "was reassigned to the {$new_rank->department->name} department";
         $this->createEntry($user_id, $message, $this->info);
      }

      // Change of Faction
      if($old_rank->department->faction->id != $new_rank->department->faction->id)
      {
         $message = "was reassigned to the {$new_rank->department->faction->name} faction";
         $this->createEntry($user_id, $message, $this->info);
      }  
   }

   /**
    * Create database entry.
    */
   private function createEntry(Int $id, String $action, String $color): void
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
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6
}
