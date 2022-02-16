<?php

namespace Rancor\Scanner\Notifications;

use Illuminate\Support\Facades\Http;
use Rancor\Scanner\Models\Territory;

class PatrolReminder
{
	/**
	 * Webhook uri to send notification
	 */
	public $webhook = null;

	/**
	 * Selects all applicable Territories from database for the Discord message
	 *
	 * @return void
	 */
	public function __invoke()
	{
		$this->webhook = config('rancor.discord.patrol');
		
		if($this->webhook == null) return;

		foreach([true, false] as $filter)
		{
			$territories = $this->query($filter);

			if($territories->isEmpty()) return;

			$message = $this->buildMessage($territories);

			$file = tmpfile();
			if(fwrite($file, $message) === false) return;
			fseek($file, 0);
			
			$this->notifyDiscord($file, $territories->count(), $filter);
			fclose($file);
		}
	}

	/**
	 * Queries the appropriate Territories to notify via Discord
	 *
	 * @param bool  $old
	 * @return  \Illuminate\Support\Collection
	 */
	private function query(Bool $old=false)
	{
		return Territory::select(['x_coordinate', 'y_coordinate'])
					->where('subscription', true)
					->when($old, function($query) {
						return $query->where('last_patrol', '<', now()->subMonths(3));
					}, function($query) {
						return $query->where([
							['last_patrol', '>=', now()->subMonths(3)],
							['last_patrol', '<', now()->subMonth()],
						]);
					})
					->get();
	}


	/**
	 * Creates the String Message to attach to the Discord message
	 *
	 * @param Illuminate\Support\Collection  $territories
	 * @return string
	 */
	private function buildMessage($territories)
	{
		$message = '';

		foreach($territories as $territory)
		{
			$message = $message . "(" . $territory->x_coordinate . ", " . $territory->y_coordinate . ")\n";
		}

		return $message;
	}

	/**
	 * Sends the HTTP Request to the Discord Webhook
	 *
	 * @param TmpFile  $file
	 * @param int  $count
	 * @param bool  $old
	 * @return void
	 */
	private function notifyDiscord($file, Int $count, Bool $old)
	{   
		$embed = $this->buildEmbed($count, $old);
		$filename = ($old ? 'urgent' : 'expired') . '_patrols_' . now()->toDateString() . '.txt';
		$payload = json_encode([
			'embeds' => [$embed],
		], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
		
		Http::attach('file', $file, $filename)
		->post($this->webhook, ['payload_json' => $payload]);
	}

	/**
	 * Creates Embeds array to send via Discord Webhook
	 *
	 * @param int  $count
	 * @param bool  $old
	 * @return array
	 */
	private function buildEmbed(Int $count, Bool $old)
	{
		return [
			'title' => 'Patrol Reminder',
			'description' => $old ? 'Coordinates that require immediate attention' : 'Coordinates that should be patrolled soon',
			'color' => $old ? '15158332' : '15844367',
			'timestamp' => now()->toDateTimeString(),
			'fields' => [
				[
					'name' => 'Total Systems',
					'value' => $count,
					'inline' => true,
				],
				[
					'name' => 'Last Scanned',
					'value' => $old ? 'Over 3 months ago' : '1-3 months ago',
					'inline' => true,
				],
			]
		];
	}
}