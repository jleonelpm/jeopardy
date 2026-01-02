<?php

namespace App\Filament\Resources\Questions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class QuestionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')
                    ->label('Categoría')
                    ->relationship('category', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->helperText('Selecciona la categoría a la que pertenece esta pregunta'),

                Textarea::make('question_text')
                    ->label('Pregunta')
                    ->required()
                    ->minLength(10)
                    ->maxLength(1000)
                    ->columnSpanFull()
                    ->helperText('El texto de la pregunta (10-1000 caracteres)'),

                Textarea::make('correct_answer')
                    ->label('Respuesta Correcta')
                    ->required()
                    ->minLength(1)
                    ->maxLength(500)
                    ->columnSpanFull()
                    ->helperText('La respuesta correcta a esta pregunta'),

                TextInput::make('points')
                    ->label('Puntos')
                    ->required()
                    ->numeric()
                    ->minValue(100)
                    ->maxValue(1000)
                    ->step(100)
                    ->default(200)
                    ->helperText('Puntos otorgados por respuesta correcta (100-1000)'),

                TextInput::make('time_limit')
                    ->label('Tiempo Límite (segundos)')
                    ->required()
                    ->numeric()
                    ->minValue(10)
                    ->maxValue(300)
                    ->default(45)
                    ->helperText('Tiempo disponible para responder (10-300 segundos)'),
            ]);
    }
}
