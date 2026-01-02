<?php

namespace App\Filament\Resources\Teams\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TeamForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('game_id')
                    ->label('Partida')
                    ->relationship('game', 'id')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->helperText('La partida a la que pertenece este equipo'),

                TextInput::make('name')
                    ->label('Nombre del Equipo')
                    ->required()
                    ->minLength(2)
                    ->maxLength(100)
                    ->placeholder('Ej: Los Campeones')
                    ->helperText('Nombre único del equipo (2-100 caracteres)'),

                ColorPicker::make('color')
                    ->label('Color')
                    ->required()
                    ->format('hex')
                    ->helperText('Color distintivo del equipo en la interfaz'),

                TextInput::make('score')
                    ->label('Puntuación Actual')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->default(0)
                    ->helperText('Puntuación acumulada del equipo'),
            ]);
    }
}

