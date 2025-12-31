<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Game;
use App\Models\Team;
use App\Models\User;
use App\Models\Question;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $moderator = User::where('role', 'moderador')->first();

        if (!$moderator) {
            $this->command->warn('No hay moderadores en la base de datos. Ejecuta ModeratorSeeder primero.');
            return;
        }

        // Crear partida en preparación
        $gamePrep = Game::create([
            'user_id' => $moderator->id,
            'status' => 'preparacion',
            'current_turn_team_id' => null,
            'started_at' => null,
            'ended_at' => null,
        ]);

        // Crear 2 equipos para la partida en preparación
        Team::create([
            'game_id' => $gamePrep->id,
            'name' => 'Equipo Rojo',
            'color' => 'red',
            'score' => 0,
        ]);

        Team::create([
            'game_id' => $gamePrep->id,
            'name' => 'Equipo Azul',
            'color' => 'blue',
            'score' => 0,
        ]);

        $this->command->info("Partida en preparación creada (ID: {$gamePrep->id}) con 2 equipos");

        // Crear partida en curso
        $gameInProgress = Game::create([
            'user_id' => $moderator->id,
            'status' => 'en_curso',
            'started_at' => now(),
            'ended_at' => null,
        ]);

        // Crear 3 equipos para la partida en curso
        $team1 = Team::create([
            'game_id' => $gameInProgress->id,
            'name' => 'Los Tigres',
            'color' => 'orange',
            'score' => 300,
        ]);

        Team::create([
            'game_id' => $gameInProgress->id,
            'name' => 'Los Delfines',
            'color' => 'cyan',
            'score' => 200,
        ]);

        Team::create([
            'game_id' => $gameInProgress->id,
            'name' => 'Los Halcones',
            'color' => 'green',
            'score' => 400,
        ]);

        // Asignar primer turno
        $gameInProgress->update(['current_turn_team_id' => $team1->id]);

        // Asignar preguntas a la partida en curso
        $questions = Question::limit(15)->get();
        foreach ($questions as $question) {
            $gameInProgress->gameQuestions()->create([
                'question_id' => $question->id,
                'used' => fake()->boolean(30), // 30% de probabilidad de estar usada
            ]);
        }

        $this->command->info("Partida en curso creada (ID: {$gameInProgress->id}) con 3 equipos y 15 preguntas");

        // Crear partida finalizada
        $gameFinished = Game::create([
            'user_id' => $moderator->id,
            'status' => 'finalizada',
            'started_at' => now()->subHours(2),
            'ended_at' => now()->subHour(),
        ]);

        // Crear 4 equipos para la partida finalizada
        Team::create([
            'game_id' => $gameFinished->id,
            'name' => 'Equipo A',
            'color' => 'purple',
            'score' => 800,
        ]);

        Team::create([
            'game_id' => $gameFinished->id,
            'name' => 'Equipo B',
            'color' => 'pink',
            'score' => 650,
        ]);

        Team::create([
            'game_id' => $gameFinished->id,
            'name' => 'Equipo C',
            'color' => 'yellow',
            'score' => 550,
        ]);

        Team::create([
            'game_id' => $gameFinished->id,
            'name' => 'Equipo D',
            'color' => 'red',
            'score' => 450,
        ]);

        $this->command->info("Partida finalizada creada (ID: {$gameFinished->id}) con 4 equipos");
        $this->command->info("Total: 3 partidas creadas con diferentes estados");
    }
}
