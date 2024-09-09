<?php

namespace App\Filament\Plugins\CustomFilamentInvoices;

use App\Filament\Resources\InvoiceResource;
use Filament\Panel;
use TomatoPHP\FilamentInvoices\Filament\Resources\InvoiceResource\Pages\InvoiceStatus;
use TomatoPHP\FilamentInvoices\FilamentInvoicesPlugin;

class CustomFilamentInvoicesPlugin extends FilamentInvoicesPlugin
{
    public function register(Panel $panel): void
    {
        $panel->resources([
            InvoiceResource::class
        ])->pages([
            InvoiceStatus::class
        ]);
    }
}
