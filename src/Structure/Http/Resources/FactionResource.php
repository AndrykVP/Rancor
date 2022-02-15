<?php

namespace Rancor\Structure\Http\Resources;

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
            'description' => $this->description,
            'departments' => DepartmentResource::collection($this->whenLoaded('departments')),
            'ranks' => RankResource::collection($this->whenLoaded('ranks')),
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans(),
        ];
    }
}
