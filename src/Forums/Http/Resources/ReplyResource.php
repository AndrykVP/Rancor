<?php

namespace AndrykVP\Rancor\Forums\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use AndrykVP\Rancor\Auth\Http\Resources\UserResource;

class ReplyResource extends JsonResource
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
            'body' => clean($this->body),
            'author' => new UserResource($this->whenLoaded('author')),
            'editor' => new UserResource($this->whenLoaded('editor')),
            'discussion' => new DiscussionResource($this->whenLoaded('discussion')),
            'created_at' => $this->created_at->format(config('rancor.dateFormat')),
            'updated_at' => $this->updated_at->format(config('rancor.dateFormat')),
        ];
    }
}
