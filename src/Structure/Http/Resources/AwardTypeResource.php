<?php

namespace Rancor\Structure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AwardTypeResource extends JsonResource
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
			'awards' => AwardResource::collection($this->whenLoaded('awards')),
			'created_at' => $this->created_at->diffForHumans(),
			'updated_at' => $this->updated_at->diffForHumans(),
		];
	}
}
