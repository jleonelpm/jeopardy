<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Question;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();

        if ($categories->isEmpty()) {
            $this->command->warn('No hay categorías en la base de datos.');
            return;
        }

        foreach ($categories as $category) {
            for ($i = 1; $i <= 10; $i++) {
                Question::create([
                    'category_id' => $category->id,
                    'question_text' => "Pregunta {$i} de {$category->name}",
                    'correct_answer' => "Respuesta {$i} de {$category->name}",
                    'points' => [100, 200, 300, 400, 500][($i - 1) % 5],
                    'time_limit' => 30,
                    'is_used' => false,
                ]);
            }

            $this->command->info("10 preguntas creadas para la categoría: {$category->name}");
        }
    }
}
