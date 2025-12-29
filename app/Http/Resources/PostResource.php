<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class PostResource extends JsonResource 
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'excerpt' => $this->when($request->has('excerpt'), function () {
                return str($this->content)->limit(150);
            }),
            'published_at' => $this->published_at ? Carbon::parse($this->published_at)->format('Y-m-d H:i:s') : null,
            'status' => $this->published_at ? 'published' : 'draft',
            'comments_count' => $this->whenCounted('comments'),
            'created_at' => $this->created_at ? Carbon::parse($this->created_at)->format('Y-m-d H:i:s') : null,
            'updated_at' => $this->updated_at ? Carbon::parse($this->updated_at)->format('Y-m-d H:i:s') : null,

            'category' => new CategoryResource($this->whenLoaded('category')),
            'author' => new AuthorResource($this->whenLoaded('author')),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'topics' => TopicResource::collection($this->whenLoaded('topics')),
        ];
    }
}
