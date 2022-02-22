<?php

namespace Rancor\SWC\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;
use Rancor\SWC\Models\Sector;

class ProcessSector implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	/**
	 * Sector UID from SWC API
	 * 
	 * @var string
	 */
	protected $uid;

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct($uid)
	{
		$this->uid = $uid;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		$id = (int)explode(':',$this->uid)[1];
		$response = Http::withHeaders([
			'Accept' => 'application/json'
		])->get(`https://www.swcombine.com/ws/v2.0/galaxy/sectors/{$this->uid}`);

		if($response->successful())
		{
			$query = $response->json();
			$query = $query['swcapi']['sector'];
	
			$model = Sector::firstOrNew(['id' => $id]);
			$model->name = $query['name'];
			$model->color = sprintf("#%02x%02x%02x", $query['colour']['r'], $query['colour']['g'], $query['colour']['b']);
			$model->save();
		}
	}

	/**
	 * The job failed to process.
	 *
	 * @param  Throwable  $exception
	 * @return void
	 */
	public function failed(Throwable $exception)
	{
		Log::channel('rancor')->error('Error thrown while attempting to process Sector: ' . $exception->getMessage());
	}
}
