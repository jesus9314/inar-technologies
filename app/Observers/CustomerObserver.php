<?php

namespace App\Observers;

use App\Models\Customer;
use App\Models\CustomerLog;
use Illuminate\Support\Carbon;

class CustomerObserver
{
    /**
     * Handle the Customer "created" event.
     */
    public function created(Customer $customer): void
    {
        $today = Carbon::today()->toDateString();
        $existingLog = CustomerLog::where('date', $today)->first();

        if ($existingLog) {
            $existingLog->increment('count');
        } else {
            CustomerLog::create([
                'date' => $today,
                'count' => 1,
            ]);
        }
    }

    /**
     * Handle the Customer "updated" event.
     */
    public function updated(Customer $customer): void
    {
        //
    }

    /**
     * Handle the Customer "deleted" event.
     */
    public function deleted(Customer $customer): void
    {
        //
    }

    /**
     * Handle the Customer "restored" event.
     */
    public function restored(Customer $customer): void
    {
        //
    }

    /**
     * Handle the Customer "force deleted" event.
     */
    public function forceDeleted(Customer $customer): void
    {
        //
    }
}
