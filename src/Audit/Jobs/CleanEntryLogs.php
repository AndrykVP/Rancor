<?php

namespace Rancor\Audit\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
<<<<<<< HEAD
use Rancor\Audit\Models\EntryLog;
=======
use AndrykVP\Rancor\Audit\Models\EntryLog;
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6
use Throwable;

class CleanEntryLogs implements ShouldQueue, ShouldBeUnique
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

<<<<<<< HEAD
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
		return EntryLog::where('created_at', '<', now()->subYear())->delete();
	}

	/**
	 * Handle a job failure.
	 *
	 * @param  \Throwable  $exception
	 * @return void
	 */
	public function failed(Throwable $exception)
	{
		Log::channel('rancor')->warning('Error thrown while attempting to clean the scanner entry changelog: ' . $exception->getMessage());
	}
=======
    public $uniqueFor = 3600;
    public $tries = 5;

    public function handle(): void
    {
        EntryLog::where('created_at', '<', now()->subYear())->delete();
    }

    public function failed(Throwable $exception): void
    {
        Log::channel('rancor')->warning('Error thrown while attempting to clean the scanner entry changelog: ' . $exception);
    }
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6
}