<?php

namespace AndrykVP\Rancor\Faction\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RankResource extends JsonResource
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
            'level' => $this->level,
            'department' => new DepartmentResource($this->whenLoaded('department')),
            'created_at' => $this->created_at->format('M j, Y, G:i e'),
        ];
    }
}
