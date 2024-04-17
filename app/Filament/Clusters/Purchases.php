<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class Purchases extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-s-folder-open';

    protected static ?string $navigationLabel = 'Compras';

    protected static ?string $navigationGroup = 'Productos y Servicios';

    protected static ?string $modelLabel = 'Compra';

    protected static ?string $pluralModelLabel = 'Compras';
}
