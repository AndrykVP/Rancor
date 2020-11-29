<?php

namespace AndrykVP\Rancor\Auth\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use AndrykVP\Rancor\Faction\Http\Resources\RankResource;

class UserResource extends JsonResource
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
            'nickname' => $this->nickname,
            'quote' => $this->quote,
            'avatar' => $this->avatar,
            'email' => $this->email,
            'joined' => $this->created_at->format('M j, Y, G:i e'),
            'last_login' => $this->when($this->last_login != null, function() {
                return $this->last_login->format('M j, Y, G:i e');
            }),
            'rank' => new RankResource($this->whenLoaded('rank')),
            'permissions' => PermissionResource::collection($this->whenLoaded('permissions')),
            'roles' => RoleResource::collection($this->whenLoaded('roles')),
        ];;
    }
}