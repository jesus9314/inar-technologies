<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum ProcessorManufacturerEnum: string implements HasLabel, HasColor, HasIcon
{
    case INTEL = 'Intel';
    case AMD = 'AMD';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::INTEL => 'Intel',
            self::AMD => 'AMD',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::INTEL => 'primary',
            self::AMD => 'gray',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::INTEL => 'heroicon-o-building-office',
            self::AMD => 'heroicon-m-beaker',
        };
    }
}
