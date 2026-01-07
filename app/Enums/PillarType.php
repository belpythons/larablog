<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum PillarType: string implements HasLabel, HasColor
{
    case Ecosystem = 'ecosystem';
    case StarterKit = 'starter_kit';
    case Bricks = 'bricks';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Ecosystem => 'Ecosystem Decisions',
            self::StarterKit => 'Starter Kits',
            self::Bricks => 'The Bricks',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Ecosystem => 'info',
            self::StarterKit => 'success',
            self::Bricks => 'warning',
        };
    }
}
