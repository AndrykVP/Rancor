<?php

namespace AndrykVP\Rancor\Auth\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
            'joined' => $this->created_at->format('M j, Y, G:i e'),
            'last_login' => $this->when($this->last_login != null, function() {
                return $this->last_login->format('M j, Y, G:i e');
            }),
            $this->mergeWhen($this->rank_id != null, function() {
                return [
                    'rank' => [
                        'id' => $this->rank->id,
                        'name' => $this->rank->name
                    ],
                    'department' => [
                        'id' => $this->rank->department->id,
                        'name' => $this->rank->department->name
                    ],
                    'faction' => [
                        'id' => $this->rank->department->faction->id,
                        'name' => $this->rank->department->faction->name
                    ],
                ];
            }),
            'permissions' => $this->when($this->permissions()->count() > 0, function() {
                $array = [];
                foreach($this->permissions as $permission)
                {
                    $array[] = [
                        'id' => $permission->id,
                        'name' => $permission->name
                    ];
                }

                return $array;
            }),
            'roles' => $this->when($this->roles()->count() > 0, function() {
                $array = [];
                foreach($this->roles as $role)
                {
                    $array[] = [
                        'id' => $role->id,
                        'name' => $role->name
                    ];
                }

                return $array;
            }),
        ];;
    }
}