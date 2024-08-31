<?php

namespace App\Filament\Widgets;

use App\Models\CustomerLog;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CustomerStats extends BaseWidget
{
    public static function canView(): bool
    {
        return true;
    }

    // protected static bool $isLazy = false;

    protected function getStats(): array
    {
        $lastMonthUsers = $this->getTotalCustomersLastMonth();
        return [
            Stat::make('Clientes', \App\Models\Customer::count())
                ->descriptionIcon('heroicon-s-user-group')
                ->description("$lastMonthUsers nuevos clientes en este mes")
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

    public function getTotalCustomersLastMonth()
    {
        // Obtén la fecha de inicio y fin del mes pasado
        $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();

        // Consulta la cantidad total de clientes registrados en el mes pasado
        $totalCustomers = CustomerLog::whereBetween('date', [$startOfLastMonth, $endOfLastMonth])
            ->sum('count');

        return $totalCustomers;
    }
}
