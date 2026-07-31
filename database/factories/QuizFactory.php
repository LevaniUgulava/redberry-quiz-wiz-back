<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Quiz>
 */
class QuizFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $images = ['img.png', 'img_1.png', 'img_2.png', 'img_3.png',
            'img_4.png', 'img_5.png', 'img_6.png', 'img_7.png','img_8.png'];

        return [
            'user_id' => $this->faker->numberBetween(1, 20),
            'title' => $this->faker->sentence(2, true),
            'description' => $this->faker->paragraph(2, true),
            'time_limit' => $this->faker->numberBetween(2, 20) * 30,
            'difficulty_id' => $this->faker->numberBetween(1, 6),
            'points' => $this->faker->numberBetween(10, 100),
            'image_url' => 'quiz/'.$this->faker->randomElement($images),

        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Quiz $quiz) {
            Question::factory(10)->create([
                'quiz_id' => $quiz->id,
            ]);
            $quiz->categories()->attach(
                Category::inRandomOrder()->take(rand(1, 3))->pluck('id')
            );
        });
    }
}
