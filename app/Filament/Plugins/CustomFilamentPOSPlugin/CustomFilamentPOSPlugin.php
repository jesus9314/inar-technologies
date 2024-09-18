<?php

namespace App\Filament\Plugins\CustomFilamentPOSPlugin;

use App\Filament\Plugins\CustomFilamentPOSPlugin\Pages\Pos;
use Filament\Panel;
use TomatoPHP\FilamentAccounts\FilamentAccountsPlugin;
use TomatoPHP\FilamentEcommerce\FilamentEcommercePlugin;
use TomatoPHP\FilamentPos\Filament\Widgets\POSStateWidget;
use TomatoPHP\FilamentPos\FilamentPOSPlugin as BaseFilamentPOSPlugin;

class CustomFilamentPOSPlugin extends BaseFilamentPOSPlugin
{
    public function register(Panel $panel): void
    {
        $panel
            ->plugins([
                FilamentEcommercePlugin::make(),
                FilamentAccountsPlugin::make()
            ])
            ->pages([
                Pos::class,
            ])->widgets([
                POSStateWidget::class
            ]);
    }
}
