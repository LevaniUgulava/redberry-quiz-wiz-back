<?php

namespace Database\Factories;

use App\Enums\QuestionType;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'quiz_id' => Quiz::factory(),
            'question' => $this->faker->sentence(),
            'max_selection' =>$this->faker->numberBetween(1, 3),
            'points' => $this->faker->numberBetween(1, 3),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Question $question) {
            Answer::factory(4)->create([
                'question_id' => $question->id,
            ]);
        });
    }
}
