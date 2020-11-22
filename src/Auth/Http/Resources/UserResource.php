<?php

namespace AndrykVP\Rancor\Auth\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use AndrykVP\Rancor\Faction\Http\Resources\RankResource;
use AndrykVP\Rancor\Faction\Http\Resources\DepartmentResource;
use AndrykVP\Rancor\Faction\Http\Resources\FactionResource;

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
            'avatar' => $this->avatar,
            'email' => $this->email,
            'rank' => new RankResource($this->whenLoaded('rank')),
            'department' => new DepartmentResource($this->whenLoaded('rank.department')),
            'faction' => new FactionResource($this->whenLoaded('rank.department.faction')),
            'permissions' => new PermissionResource($this->whenLoaded('permissions')),
            'roles' => new RoleResource($this->whenLoaded('roles')),
            'joined' => $this->created_at->format('M j, Y, G:i e'),
            'last_login' => $this->when($this->last_login != null, function() {
                return $this->last_login->format('M j, Y, G:i e');
            }),
        ];;
    }
}