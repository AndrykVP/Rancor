<?php

namespace AndrykVP\Rancor\Faction\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FactionResource extends JsonResource
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
            'created_at' => $this->created_at->format('M j, Y, G:i e'),
        ];
    }
}
