<?php

namespace App\Filament\Clusters\Maintenances\Resources\MaintenanceResource\Pages;

use App\Filament\Clusters\Maintenances\Resources\MaintenanceResource;
use App\Models\Maintenance;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Torgodly\Html2Media\Actions\Html2MediaAction;

class ViewMaintenance extends ViewRecord
{
    protected static string $resource = MaintenanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Html2MediaAction::make('Imprimir')
                ->content(fn($record) => view('maintenance', ['record' => self::getAllMaintenanceData($record)]))
        ];
    }

    protected static function getAllMaintenanceData($record): Maintenance
    {
        return Maintenance::with(['maintenanceState', 'customer', 'device', 'user', 'maintenanceIssues', 'maintenanceProcedures', 'documents'])->find($record->id);
    }
}
