<?php

namespace App\Filament\Resources\Difficulties\Pages;

use App\Filament\Resources\Difficulties\DifficultyResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDifficulties extends ListRecords
{
    protected static string $resource = DifficultyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
