<?php

namespace Rancor\Auth\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
<<<<<<< HEAD
use Illuminate\Support\Facades\Auth;
=======
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6
use App\Models\User;
use Rancor\Structure\Http\Resources\RankResource;
use Rancor\Forums\Http\Resources\GroupResource;

class UserResource extends JsonResource
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
			'first_name' => $this->first_name,
			'last_name' => $this->last_name,
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
=======
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'avatar' => $this->avatar,
            'signature' => $this->signature,
            'email' => $this->email,
            'nickname' => $this->nickname,
            'quote' => $this->quote,
            'rank' => new RankResource($this->whenLoaded('rank')),
            'duty' => $this->duty,
            $this->mergeWhen(auth()->check() && auth()->user()->can('viewAny',User::class), [
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
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6
}