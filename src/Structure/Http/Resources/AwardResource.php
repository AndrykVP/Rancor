<?php

namespace Rancor\Structure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Rancor\Auth\Http\Resources\UserResource;

class AwardResource extends JsonResource
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
			'id' => $this->id,
			'name' => $this->name,
			'description' => $this->description,
			'code' => $this->code,
			'levels' => $this->levels,
			'priority' => $this->priority,
			'type' => new AwardTypeResource($this->whenLoaded('type')),
			'users' => UserResource::collection($this->whenLoaded('users')),
			'created_at' => $this->created_at->diffForHumans(),
			'updated_at' => $this->updated_at->diffForHumans(),
		];
	}
}
