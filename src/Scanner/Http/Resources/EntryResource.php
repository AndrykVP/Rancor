<?php

namespace AndrykVP\Rancor\Scanner\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\User;

class EntryResource extends JsonResource
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
            'entity' => [
                'id' => $this->id,
                'type' => $this->type,
                'name' => $this->name,
                'owner' => $this->owner,
            ],
            'location' => $this->position,
            'contributor' => $this->when($this->updated_by != null, function() {
                return [
                    'id' => $this->contributor->id,
                    'name' => $this->contributor->name,
                ];
            }),
            'last_scanned' => $this->last_seen->format('F jS, H:i T')
        ];
    }
}
