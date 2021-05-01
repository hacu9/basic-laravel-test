<?php

namespace App\Http\Resources\Models;

use App\Http\Resources\Collections\CommentCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'slug' => $this->slug,
            'content' => $this->content,
            'is_published' => $this->is_published,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'comments_count' => $this->comments_count ?? 0,
            'comments' => new CommentCollection($this->whenLoaded('comments'))
        ];
    }
}
