<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Number;
use function str;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => UserResource::make($this->whenLoaded('user')),
            'topic' => TopicResource::make($this->whenLoaded('topic')),
            'title' => $this->title,
            'body' => $this->body,
            'html' => $this->html,
            'likes_count' => Number::abbreviate($this->likes_count), // 1.2k, 1.2m, 1.2b, 1.2t
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'routes' => [
                'show' => $this->showRoute(),
            ],
        ];
    }
}
