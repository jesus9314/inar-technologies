<?php

namespace App\Filament\Pages;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use ShuvroRoy\FilamentSpatieLaravelBackup\Pages\Backups;

class BackupsPage extends Backups
{
    // add this for work with BezhanSalleh\FilamentShield
    use HasPageShield;

    public static function getNavigationGroup(): ?string
    {
        return 'Sistema';
    }
}
