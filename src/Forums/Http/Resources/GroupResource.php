<?php

namespace AndrykVP\Rancor\Forums\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use AndrykVP\Rancor\Auth\Http\Resources\UserResource;

class GroupResource extends JsonResource
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
            'color' => $this->color,
            'users' => UserResource::collection($this->whenLoaded('users')),
            'boards' => BoardResource::collection($this->whenLoaded('boards')),
            'created_at' => $this->created_at->format(config('rancor.dateFormat')),
            'updated_at' => $this->updated_at->format(config('rancor.dateFormat')),
        ];
    }
}
