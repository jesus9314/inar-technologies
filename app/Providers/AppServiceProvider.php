<?php

namespace App\Providers;

use App\Models\Company;
use App\Models\Customer;
use App\Models\Device;
use App\Models\User;
use App\Observers\DeviceObserver;
use App\Observers\UserObserver;
use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;
use Illuminate\Support\ServiceProvider;
use App\Policies\ActivityPolicy;
use Spatie\Activitylog\Models\Activity;
use TomatoPHP\FilamentInvoices\Facades\FilamentInvoices;
use TomatoPHP\FilamentInvoices\Services\Contracts\InvoiceFor;
use TomatoPHP\FilamentInvoices\Services\Contracts\InvoiceFrom;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);
        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch
                ->locales(['es', 'en']); // also accepts a closure
        });
        FilamentInvoices::registerFor([
            InvoiceFor::make(Customer::class)
                ->label('Customer')
        ]);
        FilamentInvoices::registerFrom([
            InvoiceFrom::make(Company::class)
                ->label('Company')
        ]);
    }
}
