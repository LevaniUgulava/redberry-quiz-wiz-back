<?php

namespace App\Http\Controllers;

use App\Http\Requests\Quiz\IndexRequest;
use App\Http\Resources\QuizResource;
use App\Http\Resources\QuizWithQuestionsResource;
use App\Models\Quiz;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizController extends Controller
{
    public function index(IndexRequest $request): AnonymousResourceCollection
    {
        $perPage = $request->query('perPage', 9);
        $userId = auth()->id();
        $quiz = Quiz::with([
            'categories',
            'difficulty',
            'enrollments' => fn ($query) => $query->where('user_id', $userId),
        ])
            ->withCount('enrollments')
            ->Filter($request->validated())
            ->simplePaginate($perPage); // more optimization then paginate, that run only one query and paginate two

        return QuizResource::collection($quiz);
    }

    public function show(Quiz $quiz): JsonResource
    {
        $quiz->load('categories');

        return new QuizResource($quiz);
    }

    public function showWithQuestions(Quiz $quiz): JsonResource
    {
        $quiz->load(['questions' => function (Builder $query): void {
            $query->select('id', 'quiz_id', 'question', 'type', 'points');
        }, 'questions.answers' => function (Builder $query): void {
            $query->select('id', 'question_id', 'answer', 'is_correct');
        }]);

        return new QuizWithQuestionsResource($quiz);

    }
}
