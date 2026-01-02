<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre de Categoría')
                    ->required()
                    ->minLength(3)
                    ->maxLength(100)
                    ->unique('categories', 'name', ignoreRecord: true)
                    ->placeholder('Ej: Historia, Ciencia, Deportes')
                    ->helperText('El nombre único de la categoría (3-100 caracteres)'),

                Textarea::make('description')
                    ->label('Descripción')
                    ->minLength(10)
                    ->maxLength(500)
                    ->columnSpanFull()
                    ->placeholder('Describe el contenido de esta categoría...')
                    ->helperText('Descripción opcional de la categoría (máx 500 caracteres)'),
            ]);
    }
}
