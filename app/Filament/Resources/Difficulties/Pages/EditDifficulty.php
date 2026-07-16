<?php

namespace App\Filament\Resources\Difficulties\Pages;

use App\Filament\Resources\Difficulties\DifficultyResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDifficulty extends EditRecord
{
    protected static string $resource = DifficultyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
