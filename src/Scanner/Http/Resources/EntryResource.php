<?php

namespace AndrykVP\Rancor\Scanner\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use AndrykVP\Rancor\Auth\Http\Resources\UserResource;
use AndrykVP\Rancor\Audit\Http\Resources\EntryLogResource;

class EntryResource extends JsonResource
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
            'entity_id' => $this->entity_id,
            'type' => $this->type,
            'name' => $this->name,
            'owner' => $this->owner,
            'position' => $this->position,
            'contributor' => new UserResource($this->whenLoaded('contributor')),
            'changelog' => EntryLogResource::collection($this->whenLoaded('changelog')),
            'last_seen' => $this->last_seen->diffForHumans(),
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans(),
        ];
    }
}
