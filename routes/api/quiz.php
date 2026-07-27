<?php

use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;

Route::prefix('quiz')->group(function () {
    Route::get('/', [QuizController::class, 'index'])->name('quiz.index');
    Route::get('/{quiz}', [QuizController::class, 'show'])->name('quiz.show');
    Route::get('/{quiz}/similar', [QuizController::class, 'showSimilar'])->name('quiz.similar');
    Route::get('/{quiz}/questions', [QuizController::class, 'showWithQuestions'])->name('quiz.withquestion');

    Route::middleware('auth:sanctum')->post('/{quiz}/enroll', [QuizController::class, 'enroll'])->name('quiz.enroll');
    Route::post('{quiz}/calculate',[QuizController::class, 'calculateScore'])->name('quiz.calculate');
});
