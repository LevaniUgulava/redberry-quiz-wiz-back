<?php

namespace Database\Factories;

use App\Models\Enrollment;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Enrollment>
 */
class EnrollmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'=>$this->faker->randomElement(User::all()->pluck('id')->toArray()),
            'quiz_id'=>$this->faker->numberBetween(1, 20),
            'completed_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'points'=>$this->faker->randomFloat(2, 10, 20),
        ];
    }
}
