<?php

namespace AndrykVP\Rancor\Forums\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use AndrykVP\Rancor\Auth\Http\Resources\UserResource;

class DiscussionResource extends JsonResource
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
            'title' => $this->title,
            'is_sticky' => $this->is_sticky,
            'views' => $this->views,
            'board' => new BoardResource($this->whenLoaded('board')),
            'author' => new UserResource($this->whenLoaded('author')),
            'replies' => ReplyResource::collection($this->whenLoaded('replies')),
            'latest_reply' => new ReplyResource($this->whenLoaded('latest_reply')),
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans(),
        ];
    }
}
