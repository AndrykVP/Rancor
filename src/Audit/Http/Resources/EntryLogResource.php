<?php

namespace Rancor\Audit\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Rancor\Auth\Http\Resources\UserResource;
use Rancor\Scanner\Http\Resources\EntryResource;

class EntryLogResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array
	 */
	public function toArray($request)
	{
		return [
			'changes' => [
				'type' => $this->when($this->old_type != null, function() {
					return $this->old_type;
				}),
				'name' => $this->when($this->old_name != null, function() {
					return $this->old_name;
				}),
				'owner' => $this->when($this->old_owner != null, function() {
					return $this->old_owner;
				}),
				'position' => $this->when($this->old_position != null, function() {
					return $this->old_position;
				}),
			],
			'creator' => new UserResource($this->whenLoaded('creator')),
			'entry' => new EntryResource($this->whenLoaded('entry')),
			'created_at' => $this->created_at->diffForHumans(),
			'updated_at' => $this->updated_at->diffForHumans(),
		];
	}
}
