<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\Category;
use Illuminate\Database\Seeder;

class InvestigacionQuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $investigacionCategory = Category::where('name', 'Investigación')->first();

        if (!$investigacionCategory) {
            $this->command->error('La categoría Investigación no existe.');
            return;
        }

        $questions = [
            [
                'question_text' => '¿Qué es una revisión sistemática de literatura?',
                'correct_answer' => 'Un método riguroso para identificar, evaluar y sintetizar todos los estudios relevantes sobre un tema específico',
                'points' => 100,
                'time_limit' => 30,
            ],
            [
                'question_text' => '¿Qué significa el término "sesgo de publicación" en investigación?',
                'correct_answer' => 'La tendencia a publicar solo estudios con resultados positivos o significativos, omitiendo los negativos',
                'points' => 200,
                'time_limit' => 35,
            ],
            [
                'question_text' => '¿Qué es el método científico?',
                'correct_answer' => 'Un proceso sistemático de observación, formulación de hipótesis, experimentación y análisis para obtener conocimiento',
                'points' => 100,
                'time_limit' => 30,
            ],
            [
                'question_text' => '¿Qué diferencia existe entre investigación cualitativa y cuantitativa?',
                'correct_answer' => 'La cualitativa explora fenómenos en profundidad usando datos descriptivos, mientras la cuantitativa usa datos numéricos y estadísticas',
                'points' => 200,
                'time_limit' => 40,
            ],
            [
                'question_text' => '¿Qué es un grupo de control en un experimento?',
                'correct_answer' => 'El grupo que no recibe el tratamiento experimental y sirve como referencia para comparar resultados',
                'points' => 150,
                'time_limit' => 30,
            ],
            [
                'question_text' => '¿Qué significa el valor p (p-value) en estadística?',
                'correct_answer' => 'La probabilidad de obtener los resultados observados si la hipótesis nula fuera verdadera',
                'points' => 250,
                'time_limit' => 40,
            ],
            [
                'question_text' => '¿Qué es el plagio académico?',
                'correct_answer' => 'Usar ideas, palabras o trabajos de otros sin dar crédito apropiado o presentarlos como propios',
                'points' => 100,
                'time_limit' => 25,
            ],
            [
                'question_text' => '¿Qué es la triangulación en investigación?',
                'correct_answer' => 'El uso de múltiples métodos, fuentes de datos o investigadores para validar hallazgos y aumentar la credibilidad',
                'points' => 200,
                'time_limit' => 35,
            ],
            [
                'question_text' => '¿Qué es el factor de impacto de una revista científica?',
                'correct_answer' => 'Una métrica que mide la frecuencia promedio con la que se citan los artículos de esa revista',
                'points' => 150,
                'time_limit' => 30,
            ],
            [
                'question_text' => '¿Qué es una variable dependiente en un estudio experimental?',
                'correct_answer' => 'La variable que se mide o observa como resultado del cambio en la variable independiente',
                'points' => 150,
                'time_limit' => 30,
            ],
        ];

        foreach ($questions as $questionData) {
            Question::create([
                'category_id' => $investigacionCategory->id,
                'question_text' => $questionData['question_text'],
                'correct_answer' => $questionData['correct_answer'],
                'points' => $questionData['points'],
                'time_limit' => $questionData['time_limit'],
                'is_used' => false,
            ]);
        }

        $this->command->info('10 preguntas agregadas exitosamente a la categoría Investigación.');
    }
}
