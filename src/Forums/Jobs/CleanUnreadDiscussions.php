<?php

namespace Rancor\Forums\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Throwable;

class CleanUnreadDiscussions implements ShouldQueue, ShouldBeUnique
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	/**
	 * The number of seconds after which the job's unique lock will be released.
	 *
	 * @var int
	 */
	public $uniqueFor = 3600;

	/**
	 * The number of times the job may be attempted.
	 *
	 * @var int
	 */
	public $tries = 5;

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		return DB::table('forum_unread_discussions')
		->where('updated_at', '<', now()->subMonths(config('rancor.inactivity.forums')))
		->orWhereIn('user_id', function($query) {
			$query->select('id')
			->from('users')
			->where('users.last_seen_at', '<', now()->subMonths(config('rancor.inactivity.users')));
		})->delete();
	}

	/**
	 * Handle a job failure.
	 *
	 * @param  \Throwable  $exception
	 * @return void
	 */
	public function failed(Throwable $exception)
	{
		Log::channel('rancor')->warning('Error thrown while attempting to clean the unread discussions: ' . $exception->getMessage());
	}
}