<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizWithQuestionsResource extends JsonResource
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
            'title' => $this->title,
            'categories' => $this->categories->pluck('name'),
            'points' => $this->points,
            'time_limit' => $this->time_limit,
            'started_at' => $this->enrollments->first()?->started_at,
            'total_user' => $this->enrollments_count,
            'questions' => $this->questions,
        ];
    }
}
