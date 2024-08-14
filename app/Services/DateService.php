<?php

namespace App\Services;

use App\Models\Meeting;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DateService
{
    public function getAvailableTimesForDate(string $date): array
    {
        $date                  = Carbon::parse($date);
        $startPeriod           = $date->copy()->hour(9);
        $endPeriod             = $date->copy()->hour(17);
        $times                 = CarbonPeriod::create($startPeriod, '2 hours', $endPeriod);
        $availableReservations = [];

        $reservations = Meeting::whereDate('starts_at', $date)
            ->pluck('starts_at')
            ->toArray();

        $availableTimes = $times->filter(function ($time) use ($reservations) {
            return ! in_array($time, $reservations);
        })->toArray();

        foreach ($availableTimes as $time) {
            $key                         = $time->format('H');
            $availableReservations[$key] = $time->format('H:i');
        }

        return $availableReservations;
    }
}
