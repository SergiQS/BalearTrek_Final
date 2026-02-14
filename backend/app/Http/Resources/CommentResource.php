<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'comment' => $this->comment,
            'score' => $this->score,
            'user_id' => $this->user_id,
            'meeting_id' => $this->meeting_id,
            'user' => new UserResource($this->whenLoaded('user')),

        ];
    }
}
