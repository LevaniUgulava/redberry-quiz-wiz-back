<?php

namespace App\Filament\Resources\Difficulties\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DifficultyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                TextInput::make('name')
                    ->required()
                    ->placeholder('write difficult name'),
                ColorPicker::make('hex')
                    ->label('Difficulty Color ')
                    ->required()
                    ->placeholder('Choose color'),
            ]);
    }
}
