<?php

namespace App\Filament\Clusters\Maintenances\Resources\MaintenanceStateResource\Pages;

use App\Filament\Clusters\Maintenances\Resources\MaintenanceStateResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageMaintenanceStates extends ManageRecords
{
    protected static string $resource = MaintenanceStateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
