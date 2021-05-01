<?php

namespace App\Http\Resources\Collections;

use App\Http\Resources\Models\CommentResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CommentCollection extends ResourceCollection
{
    public $collects = CommentResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection;
    }
}
