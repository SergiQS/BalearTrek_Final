<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MeetingResource extends JsonResource
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
            'user_id' => $this->user_id,
            'total_score' => $this->total_score,
            'count_score' => $this->count_score,
            'rating' => $this->rating,
            'day' => $this->day,
            'hour' => $this->hour,
            'time' => $this->time,
            'trek_id' => $this->trek_id,
            'user' => new UserResource($this->whenLoaded('user')),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),

        ];
    }
}
