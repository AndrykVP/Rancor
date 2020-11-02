<?php

namespace AndrykVP\Rancor\Faction\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
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
            'faction' => [
                'id' => $this->faction->id,
                'name' => $this->faction->name,
            ],
            'created_at' => $this->created_at->format('M j, Y, G:i e'),
        ];
    }
}
