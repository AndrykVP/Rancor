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
            'email' => $this->email,
            'joined' => $this->created_at,
            'last_login' => $this->last_login,
            'rank' => $this->when($this->rank_id != null, function() {
                return $this->rank->name;
            }),
            'permissions' => $this->when($this->permissions()->count() > 0, function() {
                $array = [];
                foreach($this->permissions as $permission)
                {
                    $array[] = $permission->name;
                }

                return $array;
            }),
            'roles' => $this->when($this->roles()->count() > 0, function() {
                $array = [];
                foreach($this->roles as $role)
                {
                    $array[] = $role->name;
                }

                return $array;
            }),
        ];;
    }
}
