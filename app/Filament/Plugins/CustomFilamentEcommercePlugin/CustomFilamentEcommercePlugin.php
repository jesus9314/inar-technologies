<?php

namespace App\Filament\Plugins\CustomFilamentEcommercePlugin;

use App\Filament\Plugins\CustomFilamentEcommercePlugin\Resources\OrderResource;
use App\Filament\Plugins\CustomFilamentEcommercePlugin\Resources\ProductResource;
use Filament\Panel;
use Filament\SpatieLaravelTranslatablePlugin;
use TomatoPHP\FilamentAccounts\FilamentAccountsPlugin;
use TomatoPHP\FilamentEcommerce\Filament\Pages\OrderReceiptSettingsPage;
use TomatoPHP\FilamentEcommerce\Filament\Pages\OrderSettingsPage;
use TomatoPHP\FilamentEcommerce\Filament\Pages\OrderStatusSettingsPage;
use TomatoPHP\FilamentEcommerce\Filament\Resources\CompanyResource;
use TomatoPHP\FilamentEcommerce\Filament\Resources\CouponResource;
use TomatoPHP\FilamentEcommerce\Filament\Resources\GiftCardResource;
use TomatoPHP\FilamentEcommerce\Filament\Resources\ReferralCodeResource;
use TomatoPHP\FilamentEcommerce\Filament\Resources\ShippingVendorResource;
use TomatoPHP\FilamentEcommerce\Filament\Widgets\OrderPaymentMethodChart;
use TomatoPHP\FilamentEcommerce\Filament\Widgets\OrderSourceChart;
use TomatoPHP\FilamentEcommerce\Filament\Widgets\OrdersStateWidget;
use TomatoPHP\FilamentEcommerce\Filament\Widgets\OrderStateChart;
use TomatoPHP\FilamentEcommerce\FilamentEcommercePlugin as BaseFilamentEcommercePlugin;
use TomatoPHP\FilamentSettingsHub\FilamentSettingsHubPlugin;

class CustomFilamentEcommercePlugin extends BaseFilamentEcommercePlugin
{
    public ?array $locals = ['es'];

    public function register(Panel $panel): void
    {
        $panel
            ->plugin(FilamentSettingsHubPlugin::make())
            ->plugin(
                FilamentAccountsPlugin::make()
                    ->canLogin()
                    ->canBlocked()
            )
            ->plugin(SpatieLaravelTranslatablePlugin::make()->defaultLocales($this->locals))
            ->resources([
                CompanyResource::class,
                ProductResource::class,
                OrderResource::class,
                ShippingVendorResource::class,
                CouponResource::class,
                GiftCardResource::class,
                ReferralCodeResource::class,
            ])
            ->widgets($this->useWidgets ? [
                OrdersStateWidget::class,
                OrderPaymentMethodChart::class,
                OrderSourceChart::class,
                OrderStateChart::class
            ] : [])
            ->pages([
                OrderSettingsPage::class,
                OrderStatusSettingsPage::class,
                OrderReceiptSettingsPage::class
            ]);
    }
}
