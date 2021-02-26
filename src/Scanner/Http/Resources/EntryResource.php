<?php

namespace AndrykVP\Rancor\Scanner\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use AndrykVP\Rancor\Auth\Http\Resources\UserResource;

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
            'entity' => [
                'id' => $this->id,
                'entityID' => $this->entity_id,
                'type' => $this->type,
                'name' => $this->name,
                'owner' => $this->owner,
            ],
            'location' => $this->position,
            'contributor' => new UserResource($this->whenLoaded('contributor')),
            'changelog' => LogResource::collection($this->whenLoaded('changelog')),
            'last_scanned' => $this->last_seen->format(config('rancor.dateFormat'))
        ];
    }
}
