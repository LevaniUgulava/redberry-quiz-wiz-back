<?php

namespace App\Actions;

use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Database\Eloquent\Relations\Relation;

class CalculateScoreAction
{
    public function execute(array $data, Quiz $quiz): array
    {
        $quiz->load(['difficulty', 'questions.answers' => fn (Relation $q): Relation => $q->where('is_correct', true)])->loadCount('questions');

        $answerMap = $quiz->questions->mapWithKeys(function (Question $q): array {
            return [
                $q->id => $q->answers->pluck('id')->toArray(),
            ];
        });
        $earnedPoints = 0;
        $correctAnswers = 0;
        $partialCorrectAnswers = 0;

        foreach ($data as $answer) {
            $questionId = $answer['question_id'];

            if ($answerMap->has($questionId)) {
                $correctIds = $answerMap->get($questionId);
                $submitAnswerIds = $answer['answers'];
                sort($submitAnswerIds);
                sort($correctIds);

                $questionPoint = $quiz->questions->firstWhere('id', $questionId)->points;

                if ($submitAnswerIds === $correctIds) {
                    $earnedPoints += $questionPoint;
                    $correctAnswers++;
                } else {
                    $matchedAnswers = array_intersect($submitAnswerIds, $correctIds);

                    if (count($matchedAnswers) > 0) {
                        $percent = count($matchedAnswers) / count($correctIds);
                        $earnedPoints += ($questionPoint * $percent);
                        $partialCorrectAnswers++;
                    }
                }
            }
        }

        return [
            'earnedPoints' => $earnedPoints,
            'correctAnswers' => $correctAnswers,
            'partialCorrectAnswers' => $partialCorrectAnswers,
            'wrongAnswers' => $quiz->questions_count - $correctAnswers - $partialCorrectAnswers,
            'question' => $quiz->questions_count,
            'quiz_name' => $quiz->title,
            'quiz_level' => $quiz->difficulty?->only(['name', 'hex']), ];
    }
}
