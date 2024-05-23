<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class Maintenances extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-m-cube';

    protected static ?string $navigationGroup = 'Mantenimientos';

    protected static ?string $modelLabel = 'Mantenimientos';

    protected static ?string $pluralModelLabel = 'mantenimientos';
}
