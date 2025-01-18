<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class ProductsManage extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-c-building-storefront';

    protected static ?string $navigationLabel = 'Productos';

    protected static ?string $clusterBreadcrumb = 'Productos y Servicios';

    protected static ?string $navigationGroup = 'Productos y Servicios';

    protected static ?string $modelLabel = 'Producto';

    protected static ?string $pluralModelLabel = 'Productos';
}
