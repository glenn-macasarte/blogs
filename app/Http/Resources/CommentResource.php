<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // select necessary fields only to return
        return [
            'id' => $this->id,
            'blog_id' => $this->blog_id,
            'parent_comment_id' => $this->parent_comment_id,
            'comment' => $this->comment,
            'name' => $this->name,
            'created_at' => date('F j, Y, g:i a', strtotime($this->created_at))
        ];
    }
}
