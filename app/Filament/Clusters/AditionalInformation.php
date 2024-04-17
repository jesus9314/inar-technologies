<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class AditionalInformation extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-c-bolt';

    protected static ?string $navigationLabel = 'Información adicional';

    protected static ?string $navigationGroup = 'Configuraciones';

    protected static ?string $modelLabel = 'Información adicional';

    protected static ?string $pluralModelLabel = 'Informaciones adicionales';
}
