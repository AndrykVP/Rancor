<?php

namespace Rancor\Scanner\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Rancor\Auth\Http\Resources\UserResource;
use Rancor\Audit\Http\Resources\EntryLogResource;

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
            'alliance' => $this->alliance->value,
            'territory' => new TerritoryResource($this->whenLoaded('territory')),
            'contributor' => new UserResource($this->whenLoaded('contributor')),
            'changelog' => EntryLogResource::collection($this->whenLoaded('changelog')),
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans(),
            'last_seen' => $this->when($this->last_seen != null, function() {
                return $this->last_seen->diffForHumans();
            }),
        ];
    }
}
