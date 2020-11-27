<?php

namespace AndrykVP\Rancor\News\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use AndrykVP\Rancor\Auth\Http\Resources\UserResource;

class ArticleResource extends JsonResource
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
            'content' => clean($this->content),
            'is_published' => $this->is_published,
            'author' => new UserResource($this->whenLoaded('author')),
            'editor' => new UserResource($this->whenLoaded('editor')),
            'created_at' => $this->created_at->format('M j, Y, G:i e'),
            'updated_at' => $this->updated_at->format('M j, Y, G:i e'),
        ];
    }
}
