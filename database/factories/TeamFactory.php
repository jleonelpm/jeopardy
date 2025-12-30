<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\Game;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $colors = ['red', 'blue', 'green', 'yellow', 'purple', 'orange', 'pink', 'cyan'];

        return [
            'game_id' => Game::factory(),
            'name' => fake()->word() . ' Team',
            'color' => fake()->randomElement($colors),
            'score' => 0,
        ];
    }

    /**
     * Indicate that the team has a specific name.
     */
    public function withName(string $name): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => $name,
        ]);
    }

    /**
     * Indicate that the team has a specific color.
     */
    public function withColor(string $color): static
    {
        return $this->state(fn (array $attributes) => [
            'color' => $color,
        ]);
    }

    /**
     * Indicate that the team has a specific score.
     */
    public function withScore(int $score): static
    {
        return $this->state(fn (array $attributes) => [
            'score' => $score,
        ]);
    }
}
