<?php

namespace App\Observers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        if($user->customer_id){
            $costumer = Customer::find($user->customer_id);
            $user->name = "$costumer->last_name_p $costumer->last_name_m, $costumer->name";
            $user->assignRole('cliente');
            $user->save();
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updating(User $user): void
    {
        if ($user->isDirty('avatar_url')) {
            $oldImage = $user->getOriginal('avatar_url');

            if ($oldImage) {
                Storage::disk('public')->delete($oldImage);
            }
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleting(User $user): void
    {
        // Eliminar la imagen asociada al eliminar el usuario
        if ($user->image) {
            Storage::disk('public')->delete($user->image);
        }
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
