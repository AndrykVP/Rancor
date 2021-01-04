<?php

namespace AndrykVP\Rancor\Auth\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Auth;
use App\User;
use AndrykVP\Rancor\Structure\Http\Resources\RankResource;

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
            'rank' => new RankResource($this->whenLoaded('rank')),
            'permissions' => new PermissionResource($this->whenLoaded('permissions')),
            'roles' => new RoleResource($this->whenLoaded('roles')),
            $this->mergeWhen(Auth::check() && Auth::user()->can('viewAny',User::class), [
                'joined' => $this->created_at->format('M j, Y, G:i e'),
                'last_login' => $this->when($this->last_login != null, function() {
                    return $this->last_login->format('M j, Y, G:i e');
                }),
            ]),
        ];;
    }
}