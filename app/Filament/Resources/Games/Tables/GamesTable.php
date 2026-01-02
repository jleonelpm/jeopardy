<?php

namespace App\Filament\Resources\Games\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class GamesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary'),

                TextColumn::make('user.name')
                    ->label('Moderador')
                    ->searchable()
                    ->sortable(),

                BadgeColumn::make('status')
                    ->label('Estado')
                    ->colors([
                        'info' => 'preparacion',
                        'warning' => 'en_curso',
                        'success' => 'finalizada',
                    ])
                    ->formatStateUsing(fn (string $state) => match($state) {
                        'preparacion' => 'En preparación',
                        'en_curso' => 'En curso',
                        'finalizada' => 'Finalizada',
                        default => $state,
                    }),

                IconColumn::make('is_published')
                    ->label('Publicada')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),

                TextColumn::make('num_rows')
                    ->label('Filas')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('teams_count')
                    ->label('Equipos')
                    ->counts('teams')
                    ->badge()
                    ->color('info'),

                TextColumn::make('started_at')
                    ->label('Iniciada')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('ended_at')
                    ->label('Finalizada')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Estado')
                    ->options([
                        'preparacion' => 'En preparación',
                        'en_curso' => 'En curso',
                        'finalizada' => 'Finalizada',
                    ]),

                SelectFilter::make('is_published')
                    ->label('Publicada')
                    ->options([
                        true => 'Publicadas',
                        false => 'No publicadas',
                    ]),
            ], layout: FiltersLayout::AboveContent)
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
