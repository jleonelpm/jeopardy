<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'status' => 'preparacion',
            'current_turn_team_id' => null,
            'started_at' => null,
            'ended_at' => null,
        ];
    }

    /**
     * Indicate that the game is in preparation.
     */
    public function inPreparation(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'preparacion',
            'started_at' => null,
            'ended_at' => null,
        ]);
    }

    /**
     * Indicate that the game is in progress.
     */
    public function inProgress(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'en_curso',
            'started_at' => now(),
        ]);
    }

    /**
     * Indicate that the game is finished.
     */
    public function finished(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'finalizada',
            'started_at' => now()->subHour(),
            'ended_at' => now(),
        ]);
    }
}
