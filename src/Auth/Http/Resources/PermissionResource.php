<?php

namespace Rancor\Auth\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
{
<<<<<<< HEAD
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
			'users' => UserResource::collection($this->whenLoaded('users')),
			'roles' => RoleResource::collection($this->whenLoaded('roles')),
			'created_at' => $this->created_at->diffForHumans(),
			'updated_at' => $this->updated_at->diffForHumans(),
		];
	}
=======
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'users' => UserResource::collection($this->whenLoaded('users')),
            'roles' => RoleResource::collection($this->whenLoaded('roles')),
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans(),
        ];
    }
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6
}
