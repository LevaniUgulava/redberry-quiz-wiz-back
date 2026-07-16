<?php

namespace App\Filament\Resources\Difficulties\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DifficultiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->weight('semibold')
                    ->label('Difficulty Level'),
                ColorColumn::make('hex')->label('Difficulty Color'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()->iconButton()->slideOverPosition(),
                DeleteAction::make()->iconButton(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
