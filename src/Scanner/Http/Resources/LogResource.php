<?php

namespace AndrykVP\Rancor\Scanner\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LogResource extends JsonResource
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
            'attributes' => [
                'type' => $this->when($this->old_type != null && $this->new_type != null, function() {
                    return [
                        'old' => $this->old_type,
                        'new' => $this->new_type,
                    ];
                }),
                'name' => $this->when($this->old_name != null && $this->new_name != null, function() {
                    return [
                        'old' => $this->old_name,
                        'new' => $this->new_name,
                    ];
                }),
                'owner' => $this->when($this->old_owner != null && $this->new_owner != null, function() {
                    return [
                        'old' => $this->old_owner,
                        'new' => $this->new_owner,
                    ];
                }),
                'position' => $this->when($this->old_position != null && $this->new_position != null, function() {
                    return [
                        'old' => $this->old_position,
                        'new' => $this->new_position,
                    ];
                }),
            ],
            'contributor' => $this->when($this->user_id != null, function() {
                return [
                    'id' => $this->contributor->id,
                    'name' => $this->contributor->name,
                    'avatar' => $this->contributor->avatar,
                ];
            }),
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
