<?php

namespace App\Filament\Resources\Quizzes\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Colors\Color;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class QuizzesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_url')
                    ->label('Image')
                    ->circular()
                    ->getStateUsing(fn ($record) => $record->fullImageUrl),

                TextColumn::make('difficulty.name')
                    ->badge()
                    ->color(function ($record) {
                        $hex = $record->difficulty?->hex ?? '#808080';

                        return Color::rgb($hex);
                    })->searchable(),
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('points')
                    ->icon('heroicon-o-star')
                    ->iconColor('warning')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('time_limit')
                    ->label('Time')
                    ->numeric()
                    ->formatStateUsing(fn ($state) => $state ? $state / 60 : null)
                    ->icon('heroicon-o-clock')
                    ->iconColor('warning')
                    ->suffix(' min')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make()->iconButton(),
                ActionGroup::make([
                    EditAction::make()->slideOver(),
                    DeleteAction::make(),
                ]),

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
