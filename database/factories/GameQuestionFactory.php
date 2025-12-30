<?php

namespace Database\Factories;

use App\Models\GameQuestion;
use App\Models\Game;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GameQuestion>
 */
class GameQuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'game_id' => Game::factory(),
            'question_id' => Question::factory(),
            'used' => false,
            'created_at' => now(),
        ];
    }

    /**
     * Indicate that the question has been used in the game.
     */
    public function used(): static
    {
        return $this->state(fn (array $attributes) => [
            'used' => true,
        ]);
    }
}
