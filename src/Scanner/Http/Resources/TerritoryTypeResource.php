<?php

namespace Rancor\Scanner\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TerritoryTypeResource extends JsonResource
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
			'image' => $this->image,
			'territories' => TerritoryResource::collection($this->whenLoaded('territories')),
			'territories_count' => $this->loadCount('territories'),
			'created_at' => $this->created_at->diffForHumans(),
			'updated_at' => $this->updated_at->diffForHumans(),
		];
	}
}
