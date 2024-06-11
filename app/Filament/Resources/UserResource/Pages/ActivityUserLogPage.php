<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use pxlrbt\FilamentActivityLog\Pages\ListActivities;

class ActivityUserLogPage extends ListActivities
{
    use HasPageShield;

    protected static string $resource = UserResource::class;

    public static function canAccess(array $parameters = []): bool
    {
        return auth()->user()->can('activities_user'); // Comprobar el permiso
    }
}
