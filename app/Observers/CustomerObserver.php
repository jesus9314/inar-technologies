<?php

namespace App\Observers;

use App\Models\Customer;
use App\Models\User;

class CustomerObserver
{
    /**
     * Handle the Customer "created" event.
     */
    public function created(Customer $customer): void
    {
        
        $user = User::where('customer_id', $customer->id)->get();
        dd($user);
        if ($customer->user) {
            $user->name = "$customer->last_name_p $customer->last_name_m, $customer->name";
        }
        // dd($customer);
        $user->save();
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
