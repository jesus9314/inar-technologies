<?php

namespace App\Filament\Clusters\Maintenances\Resources\MaintenanceResource\Pages;

use App\Filament\Clusters\Maintenances\Resources\MaintenanceResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMaintenance extends ViewRecord
{
    protected static string $resource = MaintenanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
