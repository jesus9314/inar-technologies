<?php

namespace App\Filament\Clusters\Maintenances\Resources\MaintenanceResource\Pages;

use App\Filament\Clusters\Maintenances\Resources\MaintenanceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMaintenance extends CreateRecord
{
    protected static string $resource = MaintenanceResource::class;
}
