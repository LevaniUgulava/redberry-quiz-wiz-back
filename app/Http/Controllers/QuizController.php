<?php

namespace App\Http\Controllers;

use App\Http\Requests\Quiz\IndexRequest;
use App\Http\Resources\QuizResource;
use App\Http\Resources\QuizWithQuestionsResource;
use App\Models\Quiz;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class QuizController extends Controller
{
    public function index(IndexRequest $request): AnonymousResourceCollection
    {
        $perPage = $request->integer('perPage', 9);
        $userId = auth('sanctum')->id();
        $quizzes = Quiz::with([
            'categories',
            'difficulty',
            'enrollments' => fn ($query) => $query->when($userId, fn ($q) => $q->where('user_id', $userId)),
        ])
            ->withCount('enrollments')
            ->Filter($request->validated())
            ->simplePaginate($perPage); // more optimization then paginate, that run only one query and paginate two

        return QuizResource::collection($quizzes);
    }

    public function show(Quiz $quiz): QuizResource
    {
        $quiz->load('categories')->loadCount(['enrollments', 'questions']);

        return new QuizResource($quiz);
    }

    public function showSimilar(Quiz $quiz): AnonymousResourceCollection
    {
        $userId = auth('sanctum')->id();
        $categories = $quiz->categories()->pluck('categories.id')->toArray();

        $quizzes = Quiz::where('id', '!=', $quiz->id)
            ->whereHas('categories', fn (Builder $query): Builder => $query->whereIn('categories.id', $categories))
            ->with([
                'categories',
                'enrollments' => fn (Builder $query): ?Builder => $query->when($userId, fn (Builder $q): Builder => $q->where('user_id', $userId))])
            ->withCount('enrollments')->inRandomOrder()->limit(3)->get();

        return QuizResource::collection($quizzes);
    }

    public function showWithQuestions(Quiz $quiz): QuizWithQuestionsResource
    {
        $quiz->load(['questions' => function (Builder $query): void {
            $query->select('id', 'quiz_id', 'question', 'type', 'points');
        }, 'questions.answers' => function (Builder $query): void {
            $query->select('id', 'question_id', 'answer');
        }]);

        return new QuizWithQuestionsResource($quiz);

    }
}
