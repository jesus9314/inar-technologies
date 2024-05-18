<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum ColorEnum:string implements HasLabel, HasColor, HasIcon
{
    case DANGER = 'danger';
    case GRAY = 'gray';
    case INFO = 'info';
    case PRIMARY = 'primary';
    case SUCCESS = 'success';
    case WARNING = 'warning';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::DANGER => 'Danger',
            self::GRAY => 'Gray',
            self::INFO => 'Info',
            self::PRIMARY => 'Primary',
            self::SUCCESS => 'Success',
            self::WARNING => 'Warning'
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::DANGER => 'danger',
            self::GRAY => 'gray',
            self::INFO => 'info',
            self::PRIMARY => 'primary',
            self::SUCCESS => 'success',
            self::WARNING => 'warning'
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::DANGER => 'heroicon-m-fire',
            self::GRAY => 'heroicon-o-sparkles',
            self::INFO => 'heroicon-m-bell-alert',
            self::PRIMARY => 'heroicon-c-currency-bangladeshi',
            self::SUCCESS => 'heroicon-c-check',
            self::WARNING => 'heroicon-m-bell-alert'
        };
    }
}
