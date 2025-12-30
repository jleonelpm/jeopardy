<?php

namespace Database\Factories;

use App\Models\Turn;
use App\Models\Game;
use App\Models\Team;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Turn>
 */
class TurnFactory extends Factory
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
            'team_id' => Team::factory(),
            'question_id' => Question::factory(),
            'is_correct' => fake()->boolean(),
            'points_awarded' => 0,
            'created_at' => now(),
        ];
    }

    /**
     * Indicate that the turn was answered correctly.
     */
    public function correct(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_correct' => true,
        ]);
    }

    /**
     * Indicate that the turn was answered incorrectly.
     */
    public function incorrect(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_correct' => false,
            'points_awarded' => 0,
        ]);
    }

    /**
     * Set the points awarded for this turn.
     */
    public function withPoints(int $points): static
    {
        return $this->state(fn (array $attributes) => [
            'points_awarded' => $points,
        ]);
    }
}
