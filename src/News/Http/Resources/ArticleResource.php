<?php

namespace Rancor\News\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Rancor\Auth\Http\Resources\UserResource;

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
			'name' => $this->name,
			'body' => clean($this->body),
			'is_published' => $this->is_published,
			'author' => new UserResource($this->whenLoaded('author')),
			'editor' => new UserResource($this->whenLoaded('editor')),
			'tags' => TagResource::collection($this->whenLoaded('tags')),
			'created_at' => $this->created_at->diffForHumans(),
			'updated_at' => $this->updated_at->diffForHumans(),
		];
	}
}
