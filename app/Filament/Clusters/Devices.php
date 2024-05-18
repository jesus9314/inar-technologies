<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class Devices extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-bar';

    protected static ?string $navigationLabel = 'Dispositivos';

    protected static ?string $navigationGroup = 'Mantenimientos';

    protected static ?string $modelLabel = 'Dispositivo';

    protected static ?string $pluralModelLabel = 'Dispositivos';
}
