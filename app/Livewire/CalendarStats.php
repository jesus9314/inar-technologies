<?php

namespace App\Livewire;

use App\Models\CustomerLog;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CalendarStats extends BaseWidget
{
    public static function canView(): bool
    {
        return true;
    }

    // protected static bool $isLazy = false;

    protected function getStats(): array
    {
        return [
            Stat::make('Clientes', \App\Models\Customer::count())
                ->descriptionIcon('heroicon-s-user-group')
                ->color('success')
                ->chart(array_values($this->getHistoricalData()))
        ];
    }

    private function getHistoricalData(): array
    {
        return CustomerLog::where('date', '>=', now()->subDays(30))
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();
    }
}
