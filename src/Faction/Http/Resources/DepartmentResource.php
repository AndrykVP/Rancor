<?php

namespace AndrykVP\Rancor\Faction\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
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
            'faction' => new FactionResource($this->whenLoaded('faction')),
            'ranks' => RankResource::collection($this->whenLoaded('ranks')),
            'created_at' => $this->created_at->format('M j, Y, G:i e'),
        ];
    }
}
