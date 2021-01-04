<?php

namespace AndrykVP\Rancor\Structure\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FactionResource extends JsonResource
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
            'departments' => DepartmentResource::collection($this->whenLoaded('departments')),
            'ranks' => RankResource::collection($this->whenLoaded('ranks')),
            'created_at' => $this->created_at->format('M j, Y, G:i e'),
        ];
    }
}
