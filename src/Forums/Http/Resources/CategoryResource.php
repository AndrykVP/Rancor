<?php

namespace AndrykVP\Rancor\Forums\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'color' => $this->color,
            'slug' => $this->slug,
            'groups' => GroupResource::collection($this->whenLoaded('groups')),
            'boards' => BoardResource::collection($this->whenLoaded('boards')),
            'discussions' => GroupResource::collection($this->whenLoaded('discussions')),
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans(),
        ];
    }
}
