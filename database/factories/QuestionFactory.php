<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
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
        $points = fake()->randomElement([100, 200, 300, 400, 500]);
        $timeMap = [
            100 => 30,
            200 => 45,
            300 => 60,
            400 => 90,
            500 => 90,
        ];

        return [
            'category_id' => Category::factory(),
            'question_text' => fake()->sentence() . '?',
            'correct_answer' => fake()->sentence(),
            'points' => $points,
            'time_limit' => $timeMap[$points],
            'is_used' => false,
        ];
    }

    /**
     * Indicate that the question is easy (100 points).
     */
    public function easy(): static
    {
        return $this->state(fn (array $attributes) => [
            'points' => 100,
            'time_limit' => 30,
        ]);
    }

    /**
     * Indicate that the question is medium (200 points).
     */
    public function medium(): static
    {
        return $this->state(fn (array $attributes) => [
            'points' => 200,
            'time_limit' => 45,
        ]);
    }

    /**
     * Indicate that the question is hard (300 points).
     */
    public function hard(): static
    {
        return $this->state(fn (array $attributes) => [
            'points' => 300,
            'time_limit' => 60,
        ]);
    }

    /**
     * Indicate that the question is a challenge (400-500 points).
     */
    public function challenge(): static
    {
        return $this->state(fn (array $attributes) => [
            'points' => fake()->randomElement([400, 500]),
            'time_limit' => 90,
        ]);
    }

    /**
     * Indicate that the question has been used.
     */
    public function used(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_used' => true,
        ]);
    }
}
