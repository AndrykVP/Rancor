<?php

namespace AndrykVP\Rancor\Faction\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RankResource extends JsonResource
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
            'level' => $this->level,
            'department' => [
                'id' => $this->department->id,
                'name' => $this->department->name,
            ],
            'faction' => [
                'id' => $this->department->faction->id,
                'name' => $this->department->faction->name,
            ],
            'created_at' => $this->created_at->format('M j, Y, G:i e'),
        ];
    }
}
