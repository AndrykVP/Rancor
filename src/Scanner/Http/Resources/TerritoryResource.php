<?php

namespace AndrykVP\Rancor\Scanner\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use AndrykVP\Rancor\Auth\Http\Resources\UserResource;

class TerritoryResource extends JsonResource
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
            'coordinates' => [
                'x' => $this->x_coordinate,
                'y' => $this->y_coordinate,
            ],
            'quadrant_id' => $this->quadrant_id,
            'type' => new TerritoryTypeResource($this->whenLoaded('type')),
            'patroller' => new UserResource($this->whenLoaded('patroller')),
            'entries' => EntryResource::collection($this->whenLoaded('entries')),
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans(),
            'last_patrol' => $this->last_patrol->diffForHumans(),
        ];
    }
}