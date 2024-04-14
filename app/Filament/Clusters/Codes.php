<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class Codes extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-m-film';

    protected static ?string $navigationLabel = 'Códigos';

    protected static ?string $navigationGroup = 'Configuraciones';

    protected static ?string $modelLabel = 'Código';

    protected static ?string $pluralModelLabel = 'Códigos';
}
