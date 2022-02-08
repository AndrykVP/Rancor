<?php

namespace AndrykVP\Rancor\Audit\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use AndrykVP\Rancor\Auth\Http\Resources\UserResource;
use AndrykVP\Rancor\Scanner\Http\Resources\EntryResource;

class EntryLogResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'changes' => [
                'type' => $this->when($this->old_type != null, function() {
                    return $this->old_type;
                }),
                'name' => $this->when($this->old_name != null, function() {
                    return $this->old_name;
                }),
                'owner' => $this->when($this->old_owner != null, function() {
                    return $this->old_owner;
                }),
                'territory_id' => $this->when($this->old_territory_id != null, function() {
                    return $this->old_territory_id;
                }),
                'alliance' => $this->when($this->old_alliance != null, function() {
                    return $this->old_alliance->value;
                }),
            ],
            'creator' => new UserResource($this->whenLoaded('creator')),
            'entry' => new EntryResource($this->whenLoaded('entry')),
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans(),
        ];
    }
}
