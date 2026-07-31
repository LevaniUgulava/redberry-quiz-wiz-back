<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class QuizResource extends JsonResource
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
            'image_url' => $this->full_image_url,
            'title' => $this->title,
            'categories' => $this->categories->pluck('name'),
            'description'=>$this->description,
            'difficulty' => $this->difficulty->only('name', 'hex'),
            'total_points' => $this->points,
            'time_limit' => $this->time_limit,
            'points' => $this->CompletedPoints,
            'completed_at' => $this->completedAt?->format('j F,\ Y'),
            'started_at'=>$this->startedAt,
            'enrollments_count' => $this->enrollments_count,
            'questions_count'=>$this->questions_count
        ];
    }
}
