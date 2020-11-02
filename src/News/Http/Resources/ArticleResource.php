<?php

namespace AndrykVP\Rancor\News\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
            'author' => $this->when($this->author_id != null, function() {
                return [
                    'id' => $this->author->id,
                    'name' => $this->author->name,
                ];
            }),
            'editor' => $this->when($this->editor_id != null, function() {
                return [
                    'id' => $this->editor->id,
                    'name' => $this->editor->name,
                ];
            }),
            'created_at' => $this->created_at->format('M j, Y, G:i e'),
            'updated_at' => $this->updated_at,
        ];
    }
}
