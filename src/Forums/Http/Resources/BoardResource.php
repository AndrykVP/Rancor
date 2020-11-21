<?php

namespace AndrykVP\Rancor\Forums\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use AndrykVP\Rancor\Auth\Http\Resources\UserResource;

class BoardResource extends JsonResource
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
            'description' => $this->description,
            'uri' => $this->slug,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'parent' => new BoardResource($this->whenLoaded('parent')),
            'children' => BoardResource::collection($this->whenLoaded('children')),
            'discussions' => DiscussionResource::collection($this->whenLoaded('discussions')),
            'moderators' => UserResource::collection($this->whenLoaded('moderators')),
            'latest_reply' => new ReplyResource($this->whenLoaded('latest_reply')),
            'created_at' => $this->created_at->format(config('rancor.dateFormat')),
            'updated_at' => $this->updated_at->format(config('rancor.dateFormat')),
        ];
    }
}
