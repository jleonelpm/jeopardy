<?php

namespace App\Filament\Resources\Games\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class GameForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('Moderador')
                    ->relationship('user', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->disabled(fn ($record) => $record !== null),

                Select::make('status')
                    ->label('Estado')
                    ->options([
                        'preparacion' => 'Preparación',
                        'en_curso' => 'En curso',
                        'finalizada' => 'Finalizada'
                    ])
                    ->default('preparacion')
                    ->required()
                    ->helperText('El estado actual de la partida'),

                TextInput::make('num_rows')
                    ->label('Número de Filas')
                    ->required()
                    ->numeric()
                    ->minValue(3)
                    ->maxValue(10)
                    ->default(5)
                    ->helperText('Filas de preguntas por categoría (3-10)'),

                Toggle::make('is_published')
                    ->label('Publicada')
                    ->helperText('¿Está disponible para jugar?'),

                DateTimePicker::make('started_at')
                    ->label('Iniciada en')
                    ->displayFormat('d/m/Y H:i'),

                DateTimePicker::make('ended_at')
                    ->label('Finalizada en')
                    ->displayFormat('d/m/Y H:i')
                    ->afterOrEqual('started_at'),
            ]);
    }
}

