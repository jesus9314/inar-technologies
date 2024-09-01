<?php

namespace App\Filament\Widgets;

use Filament\Widgets\AccountWidget;

class CustomAccountWidget extends AccountWidget
{
    protected static bool $isLazy = true;

    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 3,
    ];
}
