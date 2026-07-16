<?php

namespace App\Filament\Resources\Difficulties;

use App\Filament\Resources\Difficulties\Pages\CreateDifficulty;
use App\Filament\Resources\Difficulties\Pages\ListDifficulties;
use App\Filament\Resources\Difficulties\Schemas\DifficultyForm;
use App\Filament\Resources\Difficulties\Tables\DifficultiesTable;
use App\Models\Difficulty;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class DifficultyResource extends Resource
{
    protected static ?string $model = Difficulty::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSignal;

    protected static ?string $recordTitleAttribute = 'Difficulty';

    protected static string|UnitEnum|null $navigationGroup = 'Relations';

    public static function form(Schema $schema): Schema
    {
        return DifficultyForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DifficultiesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDifficulties::route('/'),
            'create' => CreateDifficulty::route('/create'),
        ];
    }
}
