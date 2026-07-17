<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Override;

enum QuestionType: string implements HasLabel
{
    case SINGLE = 'single';
    case MULTIPLE = 'multiple';

    // this is overide funciton from haslabel contract, for filament.
    #[Override]
    public function getLabel(): string
    {
        return match ($this) {
            self::SINGLE => 'Single Choice',
            self::MULTIPLE => 'Multiple Choice'
        };
    }
}
