<?php

namespace App\Filament\Clusters\Maintenances\Resources\IssuePriorityResource\Pages;

use App\Filament\Clusters\Maintenances\Resources\IssuePriorityResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageIssuePriorities extends ManageRecords
{
    protected static string $resource = IssuePriorityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
