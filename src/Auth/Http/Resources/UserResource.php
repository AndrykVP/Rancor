<?php

namespace AndrykVP\Rancor\Auth\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Auth;
use App\Models\User;
use AndrykVP\Rancor\Structure\Http\Resources\RankResource;
use AndrykVP\Rancor\Forums\Http\Resources\GroupResource;

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
            'avatar' => $this->avatar,
            'signature' => $this->signature,
            'email' => $this->email,
            'nickname' => $this->nickname,
            'quote' => $this->quote,
            'rank' => new RankResource($this->whenLoaded('rank')),
            $this->mergeWhen(Auth::check() && Auth::user()->can('viewAny',User::class), [
                'is_admin' => $this->is_admin,
                'permissions' => PermissionResource::collection($this->whenLoaded('permissions')),
                'roles' => RoleResource::collection($this->whenLoaded('roles')),
                'groups' => GroupResource::collection($this->whenLoaded('groups')),
                'created_at' => $this->created_at->diffForHumans(),
                'updated_at' => $this->updated_at->diffForHumans(),
                'last_login' => $this->when($this->last_login != null, function() {
                    return $this->last_login->diffForHumans();
                }),
            ]),
        ];;
    }
}